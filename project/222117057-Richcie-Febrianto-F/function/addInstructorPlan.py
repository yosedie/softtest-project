from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from colorama import Fore, init
import random
import os

init()

def run_selenium_test():
    service = Service('./chromedriver.exe')
    driver = webdriver.Chrome(service=service)

    driver.maximize_window()
    driver.get('https://eclass.mediacity.co.in/demo2/public')

    login_button = driver.find_element(By.XPATH, "//a[text()='Login']")
    actions = ActionChains(driver)
    actions.move_to_element(login_button).perform()
    login_button.click()

    email_field = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "email"))
    )
    email_field.send_keys("admin@mediacity.co.in")

    password_field = driver.find_element(By.NAME, "password")
    password_field.send_keys("123456")

    decline_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.ID, "cookie-decline"))
    )
    decline_button.click()

    login_button = WebDriverWait(driver, 10).until(
        EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and contains(text(), 'Login')]"))
    )
    login_button.click()

    actions = ActionChains(driver)
    users_menu = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.XPATH, "//a[contains(@class, 'menu')]/span[contains(text(), 'Instructors')]"))
    )
    actions.move_to_element(users_menu).click().perform()

    submenu = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "ul.vertical-submenu.menu-open"))
    )

    verify_user_link = submenu.find_element(By.XPATH, ".//a[normalize-space()='Instructor Plan']")
    verify_user_link.click()

    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.LINK_TEXT, "Add Instructors Plan"))
    )
    
    add_plan_button = driver.find_element(By.LINK_TEXT, "Add Instructors Plan")
    add_plan_button.click()

    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.NAME, "title"))
    )

    project_root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    names_file = os.path.join(project_root, 'data', 'names.txt')

    with open(names_file, 'r', encoding='utf-8') as f:
        lines = [line.strip() for line in f if line.strip()]
    random_name = random.choice(lines)
    random_courses_allowed = random.randint(1, 10)
    random_duration = random.randint(1, 12)
    random_duration_type = random.choice(['d', 'm'])

    plan_name_input = driver.find_element(By.NAME, "title")
    plan_name_input.clear()
    plan_name_input.send_keys(random_name)

    current_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    file_path = os.path.join(current_dir, 'data', 'dummy-picture.jpg')
    image_input = driver.find_element(By.ID, "inputGroupFile01")
    image_input.send_keys(file_path)

    courses_allowed_input = driver.find_element(By.ID, "courses_allowed")
    courses_allowed_input.clear()
    courses_allowed_input.send_keys(str(random_courses_allowed))

    duration_input = driver.find_element(By.ID, "duration")
    duration_input.clear()
    duration_input.send_keys(str(random_duration))

    duration_type_select = driver.find_element(By.NAME, "duration_type")
    duration_type_select.send_keys(random_duration_type) 

    iframe_element = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.ID, "detail_ifr"))
    )

    driver.switch_to.frame(iframe_element)

    editor_body = WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.ID, "tinymce"))
    )

    editor_body.clear()
    editor_body.send_keys("lorem100")

    driver.switch_to.default_content()

    create_button = driver.find_element(By.XPATH, "//button[text()='Create']")
    create_button.click()

    print(Fore.GREEN + "Membuat instructor plan dengan informasi :" + Fore.RESET)
    print(Fore.GREEN + f"Nama : {random_name}" + Fore.RESET)
    print(Fore.GREEN + f"Kursus yang diperbolehkan : {random_courses_allowed}" + Fore.RESET)
    print(Fore.GREEN + f"Durasi : {random_duration}" + Fore.RESET)
    print(
        Fore.GREEN 
        + "Jenis durasi : "
        + ("Hari" if random_duration_type == "d" else "Bulan") 
        + Fore.RESET
    )
    driver.quit()

if __name__ == "__main__":
    run_selenium_test()