from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.edge.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
from webdriver_manager.microsoft import EdgeChromiumDriverManager
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.common.keys import Keys
import time

# Setup WebDriver for Edge
options = webdriver.EdgeOptions()
service = Service(EdgeChromiumDriverManager().install())
driver = webdriver.Edge(service=service, options=options)

url = "https://eclass.mediacity.co.in/demo/public/instructor"

try:
    driver.get(url)
    driver.maximize_window()
    wait = WebDriverWait(driver, 20)

    # Login
    email_field = wait.until(EC.presence_of_element_located((By.NAME, "email")))
    password_field = wait.until(EC.presence_of_element_located((By.NAME, "password")))
    email_field.send_keys("instructor@mediacity.co.in")
    password_field.send_keys("123456")

    login_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//button[@type='submit' and contains(@class, 'create-btn')]")))
    login_button.click()

    # Verify dashboard
    wait.until(EC.visibility_of_element_located((By.XPATH, "//h4[contains(text(),'Instructor Dashboard')]")))
    print("Login Successful: Dashboard Loaded")
    time.sleep(2)

    # Menunggu agar dropdown benar-benar muncul
    profile_dropdown = wait.until(EC.visibility_of_element_located((By.XPATH, "//span[contains(text(),'Hi instructor')]")))
    # Menggunakan JavaScript untuk membuka dropdown
    driver.execute_script("arguments[0].click();", profile_dropdown)

    time.sleep(2)

    # Klik logout dengan JavaScript
    logout_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//a[contains(text(),'Logout')]")))
    driver.execute_script("arguments[0].click();", logout_button)
    print("Logout Successful")

except TimeoutException as e:
    print(f"Timeout Error: {e}")

except Exception as e:
    print(f"Unexpected Error: {e}")

finally:
    # Wait to observe the result (optional)
    time.sleep(2)
    driver.quit()
