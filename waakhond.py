
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler
import time
from PIL import Image, ImageFilter, ImageDraw
import numpy
import sys
import os

options = Options()
options.add_argument("--headless")

driver = webdriver.Chrome(options=options)
driver.get("https://landingpad.me")
time.sleep(5)
driver.find_element(By.CSS_SELECTOR, ".cky-btn-accept").click()
time.sleep(3)
email_field = driver.find_element(By.ID, "LoginFormEmailInput")
email_field.send_keys("gvdkooij@gmail.com")
time.sleep(3)
next_button = driver.find_element(By.XPATH, "//span[text()='Next']")
next_button.click()
time.sleep(5)
password_field = driver.find_element(By.ID, "LoginFormPasswordInput")
password_field.send_keys("Rijnweg201")
time.sleep(4)
login_button = driver.find_element(By.XPATH, "//span[text()='Log in']")
login_button.click()
time.sleep(5)



def find_coeffs(pb, pa):
    matrix = []
    for p1, p2 in zip(pa, pb):
        matrix.append([p1[0], p1[1], 1, 0, 0, 0, -p2[0]*p1[0], -p2[0]*p1[1]])
        matrix.append([0, 0, 0, p1[0], p1[1], 1, -p2[1]*p1[0], -p2[1]*p1[1]])

    A = numpy.matrix(matrix, dtype=float)
    B = numpy.array(pb).reshape(8)

    res = numpy.dot(numpy.linalg.inv(A.T * A) * A.T, B)
    return numpy.array(res).reshape(8)




class NewFileHandler(FileSystemEventHandler):
    def on_created(self, event):
        if not event.is_directory:
            print(f"Nieuw bestand gevonden: {event.src_path}")
            bestand=event.src_path
            print(bestand)
            #time.sleep(2)
            #file_input = driver.find_element(By.CSS_SELECTOR, "input[type='file']")
            # Gebruik het nieuwe png bestand voor de upload
            #file_input.send_keys({event.src_path})
            verander_alles(bestand)
            #time.sleep(3)





def verander_alles(locatie):
    img = Image.open(locatie)
    #GaussianBlur eerst regel later toegevoegd om porbleem met shakespear te handelen
    img = img.convert("RGB")
    img = img.filter(ImageFilter.GaussianBlur(radius=img.width/300))

    #Threshold
    threshold = 128
    img = img.convert('L')
    img = img.point(lambda p: 255 if p > threshold else 0)
    img = img.convert('1')


    #Naar anamorfose
    doelbreedte = 646
    doelhoogte = 1200

    coeffs = find_coeffs(
        [(0, 0), (img.width, 0), (img.width, img.height), (0, img.height)],
        [(0, 0), (646, 0), (390, 949), (256, 949)])

    # Before the transformation
    img = img.convert('RGBA')  # Make sure image is in RGBA mode

    # Create a transparent background of the desired size
    background = Image.new('RGBA', (doelbreedte, doelhoogte), (255, 255, 255, 0))  # Transparent background

    # Perform your transformation
    transformed_img = img.transform((doelbreedte, doelhoogte), Image.PERSPECTIVE, coeffs)
    img = transformed_img




    # Paste the transformed image onto the transparent background
    # This will preserve transparency
    background.paste(transformed_img, (0, 0), transformed_img)

    # Now use background as your image for further processing
    img = background

    draw = ImageDraw.Draw(img)

    x, y, r = 323, 1200, 50  # Middelpunt (100,100) en straal 50
    draw.ellipse((x-r, y-r, x+r, y+r), fill="black")

    #pixels doorzichtigmaken
    img = img.convert('RGBA')
    pixels = img.load()

    for y in range(img.height):
        for x in range(img.width):
            r, g, b, a = pixels[x, y]

            if (r, g, b) == (255, 255, 255):
                pixels[x, y] = (255, 255, 255, 0)
            elif (r, g, b) == (0, 0, 0):
                pixels[x, y] = (0, 0, 0, 204)

    # Sla het resultaat op als PNG, ongeacht de oorspronkelijke extensie
    bestandsnaam_zonder_extensie = os.path.splitext(os.path.basename(locatie))[0]
    nieuwe_bestandsnaam = f"Z_A2000_80_{bestandsnaam_zonder_extensie}"



    img.save("/var/www/html/uploads/converted/" + nieuwe_bestandsnaam+".png", format="PNG")


    time.sleep(2)
    file_input = driver.find_element(By.CSS_SELECTOR, "input[type='file']")
    #Gebruik het nieuwe png bestand voor de upload
    file_input.send_keys("//var/www/html/uploads/converted/" + nieuwe_bestandsnaam+".png")
    # Reset het bestandsinvoerveld met JavaScript voordat je het nieuwe bestand toevoegt
    driver.execute_script("document.querySelector('input[type=\"file\"]').value = '';")






def monitor_directory(path="."):
    event_handler = NewFileHandler()
    observer = Observer()
    observer.schedule(event_handler, path, recursive=False)
    observer.start()

    try:
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        observer.stop()

    observer.join()

if __name__ == "__main__":
    monitor_directory(r"/var/www/html/uploads")


