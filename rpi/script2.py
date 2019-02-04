import mysql.connector
import time

for index in range(1, 4):
    mydb = mysql.connector.connect(
    host="10.35.51.240",
    user="dbcon",
    passwd="NYc9BVJsK1a8knMM",
    database="icoccac"
    )

    mycursor = mydb.cursor()

    mycursor.execute("SELECT * FROM tb_data WHERE location = " + str(index) + " and timestamp >= DATE_SUB(NOW(),INTERVAL 1 HOUR);")

    myresult = mycursor.fetchall()

    rowcount = len(myresult)

    sum_pm1 = 0
    sum_pm25 = 0
    sum_pm10 = 0
    location = index

    for x in myresult:
        sum_pm1 = sum_pm1 + x[2]
        sum_pm25 = sum_pm25 + x[3]
        sum_pm10 = sum_pm10 + x[4]

    sum_pm1 = sum_pm1 / rowcount
    sum_pm25 = sum_pm25 / rowcount
    sum_pm10 = sum_pm10 / rowcount

    mycursor2 = mydb.cursor()

    sql2 = "INSERT INTO tb_summary (location, pm1, pm25, pm10) VALUES (%s, %s, %s, %s)"
    val2 = (location, sum_pm1, sum_pm25, sum_pm10)
    mycursor2.execute(sql2, val2)

    mydb.commit()

    print(mycursor2.rowcount, "record inserted.")
    time.sleep(3)
