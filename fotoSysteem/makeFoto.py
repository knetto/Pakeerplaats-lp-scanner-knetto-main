from picamera import PiCamera
import time
from grove.button import Button
from grove.factory import Factory
import RPi.GPIO as IO
import upm.pyupm_jhd1313m1 as upmjhd
from grove.display.base import *
import sys, mraa
from numpy import interp
import sys
import mysql.connector

__all__ = ["JHD1802"]

camera = PiCamera()

mydb = mysql.connector.connect(
  host="192.168.2.16",
  user="root",
  password="",
  database="lp"
)

class JHD1802(Display):
    def __init__(self, address = 0x3E):
        self._bus = mraa.I2c(0)
        self._addr = address
        self._bus.address(self._addr)
        if self._bus.writeByte(0):
            print("Check if the LCD {} inserted, then try again"
                    .format(self.name))
            sys.exit(1)
        self.jhd = upmjhd.Jhd1313m1(0, address, address)

    def setCursor(self, row, column):
        self.jhd.setCursor(row, column)

    def write(self, msg):
        self.jhd.write(msg)

class GroveButton(object):
    def __init__(self, pin):
        # High = pressed
        self.__btn = Factory.getButton("GPIO-HIGH", pin)
        self.__last_time = time.time()
        self.__on_press = None
        self.__on_release = None
        self.__btn.on_event(self, GroveButton.__handle_event)
 
    @property
    def on_press(self):
        return self.__on_press
 
    @on_press.setter
    def on_press(self, callback):
        if not callable(callback):
            return
        self.__on_press = callback
 
    @property
    def on_release(self):
        return self.__on_release
 
    @on_release.setter
    def on_release(self, callback):
        if not callable(callback):
            return
        self.__on_release = callback
 
    def __handle_event(self, evt):
        dt, self.__last_time = evt["time"] - self.__last_time, evt["time"]
        # print("event index:{} event:{} pressed:{}".format(evt["index"], evt["code"], evt["pressed"]))
        if evt["code"] == Button.EV_LEVEL_CHANGED:
            if evt["pressed"]:
                if callable(self.__on_press):
                    self.__on_press(dt)
            else:
                if callable(self.__on_release):
                    self.__on_release(dt)


Grovebutton = GroveButton

IO.setwarnings(False)
IO.setmode(IO.BCM)

class GroveServo:
    MIN_DEGREE = 0
    MAX_DEGREE = 90
    INIT_DUTY = 2.5
 
    def __init__(self, channel):
        IO.setup(channel,IO.OUT)
        self.pwm = IO.PWM(channel,50)
        self.pwm.start(GroveServo.INIT_DUTY)
 
    def __del__(self):
        self.pwm.stop()
 
    def setAngle(self, angle):
        # Map angle from range 0 ~ 180 to range 25 ~ 125
        angle = max(min(angle, GroveServo.MAX_DEGREE), GroveServo.MIN_DEGREE)
        tmp = interp(angle, [0, 90], [25, 125])
        self.pwm.ChangeDutyCycle(round(tmp/10.0, 1))

Groveservo = GroveServo

class GroveServo2:
    MIN_DEGREE = 0
    MAX_DEGREE = 90
    INIT_DUTY = 2.5
 
    def __init__(self, channel):
        IO.setup(channel,IO.OUT)
        self.pwm = IO.PWM(channel,50)
        self.pwm.start(GroveServo2.INIT_DUTY)
 
    def __del__(self):
        self.pwm.stop()
 
    def setAngle(self, angle):
        # Map angle from range 0 ~ 180 to range 25 ~ 125
        angle = max(min(angle, GroveServo2.MAX_DEGREE), GroveServo2.MIN_DEGREE)
        tmp = interp(angle, [0, 90], [25, 125])
        self.pwm.ChangeDutyCycle(round(tmp/10.0, 1))

Groveservo2 = GroveServo2

def main():
    mydb = mysql.connector.connect(
        host="192.168.2.16",
        user="root",
        password="",
        database="lp"
    )
    mycursor = mydb.cursor()
    mycursor.execute("SELECT spots FROM parkingspots")
    totalSpots = mycursor.fetchone()

    lcd = JHD1802()
    lcd.setCursor(0, 0)
    lcd.write("totaal: {}".format(str(totalSpots)))
    
    servo = GroveServo(12)
    servo2 = GroveServo2(18)
    button_in = GroveButton(5)
    button_out = GroveButton(16)
 
    def on_press_in(way):
        mydb = mysql.connector.connect(
            host="192.168.2.16",
            user="root",
            password="",
            database="lp"
        )
        mycursor = mydb.cursor()
        mycursor.execute("SELECT full_spots FROM parkingspots")
        startConditions = mycursor.fetchone()
        print("in")
        while(True):
            camera.start_preview()
            camera.capture('/home/pi/test.jpg')
            camera.stop_preview()
            time.sleep(1)
            mydb = mysql.connector.connect(
                host="192.168.2.16",
                user="root",
                password="",
                database="lp"
            )
            mycursor = mydb.cursor()
            mycursor.execute("SELECT full_spots FROM parkingspots")
            postConditions = mycursor.fetchone()
            if(startConditions < postConditions):
                print("niewe geregistreerd")
                servo.setAngle(35)
                time.sleep(20)
                servo.setAngle(0)

                lcd.backlight(True)
                time.sleep(1)
                break
            else:
                print("nog geen regisratie")


    def on_press_out(way):
        mydb = mysql.connector.connect(
            host="192.168.2.16",
            user="root",
            password="",
            database="lp"
        )
        mycursor = mydb.cursor()
        mycursor.execute("SELECT full_spots FROM parkingspots")
        startConditions = mycursor.fetchone()
        print("uit")
        while(True):
            camera.start_preview()
            camera.capture('/home/pi/test.jpg')
            camera.stop_preview()
            time.sleep(1)
            mydb = mysql.connector.connect(
                host="192.168.2.16",
                user="root",
                password="",
                database="lp"
            )
            mycursor = mydb.cursor()
            mycursor.execute("SELECT full_spots FROM parkingspots")
            postConditions = mycursor.fetchone()
            if(startConditions > postConditions):
                print("uit gehaald")
                servo2.setAngle(35)
                time.sleep(20)
                servo2.setAngle(0)

                lcd.backlight(True)
                time.sleep(1)
                break
            else:
                print("nog niet uit")

    button_in.on_press = on_press_in

    button_out.on_press = on_press_out

    while True:
        time.sleep(1)
        mydb = mysql.connector.connect(
            host="192.168.2.16",
            user="root",
            password="",
            database="lp"
        )
        mycursor = mydb.cursor()
        mycursor.execute("SELECT full_spots FROM parkingspots")
        usedSpots = mycursor.fetchone()
        lcd.setCursor(1, 0)
        lcd.write("bezet: {}".format(str(usedSpots)))


if __name__ == '__main__':
    main()