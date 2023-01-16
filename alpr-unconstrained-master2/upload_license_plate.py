from sys import argv
import mysql.connector
import time    

mydb = mysql.connector.connect(
  host="172.24.32.1",
  user="root",
  password="",
  database="lp"
)

mycursor = mydb.cursor()

if len(argv[1]) > 4:
    mycursor.execute(f"SELECT ID FROM licenseplates WHERE plate = \"{argv[1]}\"")
    if len(mycursor.fetchall()) == 0:
      sql = "INSERT INTO licenseplates (plate) VALUES (%s)"
      val = (argv[1], )
      mycursor.execute(sql, val)
      print(mycursor.rowcount, "record inserted.")

    mycursor.execute(f"SELECT ID FROM licenseplates WHERE plate = \"{argv[1]}\"")

    myresult = mycursor.fetchall()

    t = myresult[0]

    print(f"Getting plate ID {t}")
    mycursor.execute(f"SELECT ID FROM licenseplate_date_times WHERE dateTime_out IS NULL AND plate_id = \"{t[0]}\"")

    myresult2 = mycursor.fetchall()
    print(myresult2)

    if len(myresult2) > 0:
        out = myresult2[0]
        sql = "UPDATE licenseplate_date_times SET dateTime_out = CURRENT_TIMESTAMP WHERE ID = %s"
        mycursor.execute(sql, out)
        mycursor.execute("UPDATE parkingspots SET full_spots = full_spots - 1 WHERE ID = 1")
        mydb.commit()
        print(mycursor.rowcount, "record updated.")
    else:
        sql = "INSERT INTO licenseplate_date_times (plate_id, dateTime_in) VALUES (%s, CURRENT_TIMESTAMP)"
        mycursor.execute(sql, t)
        mycursor.execute("UPDATE parkingspots SET full_spots = full_spots + 1 WHERE ID = 1")
        mydb.commit()
        print(mycursor.rowcount, "record inserted.")
