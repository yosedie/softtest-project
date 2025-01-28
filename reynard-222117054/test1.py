from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

# Data pengguna untuk registrasi
user_data = {
    "first_name": "John",
    "last_name": "Doe",
    "email": "johndoe5@example.com",
    "password": "password123"
}

# Inisialisasi browser Chrome
options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")
driver = webdriver.Chrome(options=options)

try:
    wait = WebDriverWait(driver, 30)  # Waktu tunggu eksplisit
    
    # 1. Buka halaman utama
    driver.get("https://eclass.mediacity.co.in/demo/public/")
    print("Berhasil membuka halaman utama.")

    # 2. Klik tombol "Register"
    register_button = wait.until(
        EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Register')]"))
    )
    register_button.click()
    print("Tombol 'Register' diklik.")

    # 3. Tunggu hingga form registrasi muncul
    wait.until(EC.presence_of_element_located((By.TAG_NAME, "form")))

    # 4. Isi form registrasi
    driver.find_element(By.ID, "fname").send_keys(user_data["first_name"])
    driver.find_element(By.NAME, "lname").send_keys(user_data["last_name"])
    driver.find_element(By.NAME, "email").send_keys(user_data["email"])
    driver.find_element(By.NAME, "password").send_keys(user_data["password"])
    driver.find_element(By.NAME, "password_confirmation").send_keys(user_data["password"])
    print("Form registrasi diisi.")

    # 5. Centang kotak "Terms and Conditions"
    terms_checkbox = driver.find_element(By.XPATH, "//input[@type='checkbox']")
    terms_checkbox.click()
    print("Checkbox 'Terms and Conditions' dicentang.")

    # 6. Klik tombol "Sign Up"
    sign_up_button = wait.until(
        EC.element_to_be_clickable((By.XPATH, "//button[@title='Sign Up']"))
    )
    driver.execute_script("arguments[0].click();", sign_up_button)
    print("Tombol 'Sign Up' diklik.")

    # 7. Tunggu hingga halaman dengan "Click here to request another" muncul
    request_another = wait.until(
        EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'click here to request another')]"))
    )
    request_another.click()
    print("'Click here to request another' diklik.")

    # 8. Tunggu hingga pesan konfirmasi berhasil muncul
    confirmation_message = wait.until(
        EC.presence_of_element_located((By.XPATH, "//div[@class='alert alert-success' and contains(text(), 'A fresh verification link has been sent')]"))
    )
    print("Pesan konfirmasi muncul:", confirmation_message.text)

    # 9. Tunggu hingga tombol logout muncul
    logout_button = wait.until(
        EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Logout')]"))
    )
    driver.execute_script("arguments[0].click();", logout_button)
    print("Tombol 'Logout' diklik.")

    # 10. Tunggu hingga kembali ke halaman utama setelah logout
    wait.until(
        EC.presence_of_element_located((By.XPATH, "//a[contains(text(), 'Login')]"))
    )
    print("Berhasil logout dan kembali ke halaman utama.")

except Exception as e:
    print(f"Terjadi kesalahan: {e}")

finally:
    # Tunggu beberapa detik sebelum menutup browser
    time.sleep(5)
    driver.quit()
