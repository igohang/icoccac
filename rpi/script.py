import serial
import time
import sys
import json
import datetime
import binascii

import RPi.GPIO as GPIO
import dht11

import mysql.connector

import aqi

# initialize GPIO
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.cleanup()

# read data using pin 14
instance = dht11.DHT11(pin=4)

class pmsA003():
    def __init__(self, dev):
        self.serial = serial.Serial(dev, baudrate=9600, timeout=3)
    def __exit__(self, exc_type, exc_value, traceback):
        self.serial.close()


    def setIdel(self):
        idelcmd = b'\x42\x4d\xe4\x00\x00\x01\x73'
        ary = bytearray(idelcmd)
        self.serial.write(ary)

    def setNormal(self):
        normalcmd = b'\x42\x4d\xe4\x00\x01\x01\x74'
        ary = bytearray(normalcmd)
        self.serial.write(ary)

    def vertify_data(self):
        if not self.data:
            return False
        return True


    def read_data(self):
        while True:
            b = self.serial.read(1)
            if b == b'\x42':
                data = self.serial.read(31)
                if data[0] == b'\x4d':
                    self.data = bytearray(b'\x42' + data)
                    if self.vertify_data():
                        return self._PMdata()

    def _PMdata(self):
        d = {}
        d['time'] = datetime.datetime.now()
        d['apm25'] = self.data[6] * 256 + self.data[7]
        d['apm10'] = self.data[4] * 256 + self.data[5]
        d['apm100'] = self.data[8] * 256 + self.data[9]
        return d

class dht11_f():
    def read(self):
        x = 0
        td = {}
        while (x != 1):
            result = instance.read()
            if result.is_valid():
                print("Last valid input: " + str(datetime.datetime.now()))
                print("Temperature: %d C" % result.temperature)
                print("Humidity: %d %%" % result.humidity)
                td['temp'] = result.temperature
                td['humi'] = result.humidity
                x = 1
                return td

if __name__ == '__main__':
    print("starting...")
    con = pmsA003('/dev/ttyAMA0')
    d = con.read_data()

    print("PM 1.0", d['apm10'])
    print("PM 2.5", d['apm25'])
    print("PM 10.0", d['apm100'])
    temp = 0
    humi = 0
    tcon = dht11_f()
    td = tcon.read()

    if(d['apm10'] == 0 or d['apm10'] > 500 or d['apm25'] == 0 or d['apm25'] > 500 or d['apm100'] == 0 or d['apm100'] > 500):
        d = con.read_data()
        if(d['apm10'] == 0 or d['apm10'] > 500 or d['apm25'] == 0 or d['apm25'] > 500 or d['apm100'] == 0 or d['apm100'] > 500):
            d = con.read_data()
            if(d['apm10'] == 0 or d['apm10'] > 500 or d['apm25'] == 0 or d['apm25'] > 500 or d['apm100'] == 0 or d['apm100'] > 500):
                d = con.read_data()
    
    pm25aqi = aqi.to_iaqi(aqi.POLLUTANT_PM25, d['apm25'], algo=aqi.ALGO_EPA)
    pm10aqi = aqi.to_iaqi(aqi.POLLUTANT_PM10, d['apm100'], algo=aqi.ALGO_EPA)

    mydb = mysql.connector.connect(
    host="10.35.51.240",
    user="dbcon",
    passwd="NYc9BVJsK1a8knMM",
    database="pm"
    )

    mycursor = mydb.cursor()
    sql = "INSERT INTO data (pm1, pm25, pm10, temp, humi, aqi_pm25, aqi_pm10) VALUES (%s, %s, %s, %s, %s, %s, %s)"
    val = (d['apm10'], d['apm25'], d['apm100'], td['temp'], td['humi'], pm25aqi, pm10aqi)
    mycursor.execute(sql, val)

    mydb.commit()

    print(mycursor.rowcount, "record inserted.")