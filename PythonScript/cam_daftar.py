import mysql.connector
import cv2
import sys
from flask import Response
import json
# import simplejson as json
from json import JSONEncoder
from dataclasses import dataclass
 
cnt = 0
pause_cnt = 0
justscanned = False
 
mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="db_absensi2"
)

mycursor = mydb.cursor() 

nubr = sys.argv[1]
# nubr = 10

def generate_dataset(nbr):
    face_classifier = cv2.CascadeClassifier("C:\\laragon\\www\\Absensi-With-Facerecog\\PythonScript\\xmlsrc\\haarcascade_frontalface_default.xml")

    def face_cropped(img):
        gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
        faces = face_classifier.detectMultiScale(gray, 1.3, 5)
 
        if faces == ():
            return None
        for (x, y, w, h) in faces:
            cropped_face = img[y:y + h, x:x + w]
        return cropped_face
 
    cap = cv2.VideoCapture(0)
 
    mycursor.execute("SELECT ifnull(max(img_id), 0) FROM images")
    row = mycursor.fetchone()
    lastid = row[0]
 
    img_id = lastid
    max_imgid = img_id + 5

    count_img = 0
 
    while True:
        ret, img = cap.read()
        if face_cropped(img) is not None:
            count_img += 1
            img_id += 1
            face = cv2.resize(face_cropped(img), (800, 500))
            face = cv2.cvtColor(face, cv2.COLOR_BGR2GRAY)
            file_name_path = "C:\\laragon\\www\\Absensi-With-Facerecog\\PythonScript\\dataset\\"+nbr+"."+ str(img_id) + ".jpg"
            cv2.imwrite(file_name_path, face)
            cv2.putText(face, str(count_img), (50, 50), cv2.FONT_HERSHEY_COMPLEX, 1, (0, 255, 0), 2)
 
            mycursor.execute("INSERT INTO `images` (`img_id`, `img_person`) VALUES ('{}', '{}')".format(img_id, str(nbr)))
            mydb.commit()
 
            frame = cv2.imencode('.jpg', face)[1].tobytes()
            yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')
 
            if cv2.waitKey(1) == 13 or int(img_id) == int(max_imgid):
                break
                cap.release()
                cv2.destroyAllWindows()

def gen_data():
    # Video streaming route. Put this in the src attribute of an img tag
    vari = json.dumps(Response(generate_dataset(nubr), mimetype='multipart/x-mixed-replace; boundary=frame'))
    return vari

@dataclass
class GenEncoder:
    def __init__(self, funcspas):
        self.funcspas = funcspas

ins = GenEncoder(funcspas=gen_data())
class InsGenEncoder(json.JSONEncoder):
    def default(self,o):
        if isinstance(o, GenEncoder):
            return {'fun1': o.funcspas}
        return super().default(o)

json_p = json.dumps(ins, cls=InsGenEncoder, indent=4)
print(json_p)






################################
# def gen_data():
#     # Video streaming route. Put this in the src attribute of an img tag
#     return json.dumps(Response(generate_dataset(nubr), mimetype='multipart/x-mixed-replace; boundary=frame'))
    
# func = {"function1": gen_data()}

# print(json.dumps(func, iterable_as_array=True))

################################

# number = {"dataset" : generate_dataset(nubr)}
# # print(number)
# print(json.dumps(number, iterable_as_array=True))