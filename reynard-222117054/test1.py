# from selenium import webdriver
# from selenium.webdriver.common.by import By
# from selenium.webdriver.edge.service import Service
# from selenium.webdriver.support.ui import WebDriverWait
# from selenium.webdriver.support import expected_conditions as EC
# from webdriver_manager.microsoft import EdgeChromiumDriverManager
# import time

# # Data pendaftaran pengguna
# signup_data = {
#     "first_name": "John",
#     "last_name": "Doe",
#     "email": "johndoe2@example.com",
#     "password": "SecurePassword123",
#     "confirm_password": "SecurePassword123"
# }

# # Inisialisasi driver Edge
# options = webdriver.EdgeOptions()
# options.add_argument("--start-maximized")
# driver = webdriver.Edge(service=Service(EdgeChromiumDriverManager().install()), options=options)

# try:
#     wait = WebDriverWait(driver, 30)  # Waktu tunggu eksplisit

#     # 1. Buka halaman utama
#     driver.get("https://eclass.mediacity.co.in/demo2/public/")
#     print("Berhasil membuka halaman utama.")

#     # 2. Klik tombol "Signup"
#     signup_button = wait.until(
#         EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Signup')]"))
#     )
#     signup_button.click()
#     print("Tombol signup diklik.")

#     # 3. Tunggu hingga form signup muncul
#     wait.until(EC.presence_of_element_located((By.NAME, "fname")))

#     # 4. Isi form signup
#     driver.find_element(By.NAME, "fname").send_keys(signup_data["first_name"])
#     driver.find_element(By.NAME, "lname").send_keys(signup_data["last_name"])
#     driver.find_element(By.NAME, "email").send_keys(signup_data["email"])
#     driver.find_element(By.NAME, "password").send_keys(signup_data["password"])
#     driver.find_element(By.NAME, "password_confirmation").send_keys(signup_data["confirm_password"])
#     print("Form signup diisi.")

#     # 5. Centang kotak "Terms & Condition"
#     terms_checkbox = driver.find_element(By.XPATH, "//input[@type='checkbox']")
#     if not terms_checkbox.is_selected():
#         terms_checkbox.click()
#     print("Checkbox 'Terms & Condition' dicentang.")

#     # 6. Klik tombol "Signup"
#     submit_button = wait.until(
#         EC.element_to_be_clickable((By.XPATH, "//button[contains(text(), 'Signup')]"))
#     )
#     submit_button.click()
#     print("Tombol signup diklik.")

#     # 7. Tunggu hingga halaman dengan "Click here to request another" muncul
#     request_another = wait.until(
#         EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'click here to request another')]"))
#     )
#     request_another.click()
#     print("'Click here to request another' diklik.")

#     # 8. Tunggu hingga tombol logout muncul
#     logout_button = wait.until(
#         EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Logout')]"))
#     )
#     driver.execute_script("arguments[0].click();", logout_button)  # Gunakan JavaScript untuk menekan tombol
#     print("Tombol 'Logout' diklik.")

#     # 9. Tunggu hingga kembali ke halaman utama setelah logout
#     wait.until(
#         EC.presence_of_element_located((By.XPATH, "//a[contains(text(), 'Login')]"))
#     )
#     print("Berhasil logout dan kembali ke halaman utama.")

# except Exception as e:
#     print(f"Terjadi kesalahan: {e}")

# finally:
#     # Tunggu sebentar sebelum menutup browser
#     time.sleep(5)
#     driver.quit()
#     print("Browser ditutup.")
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

# Data pengguna untuk login
login_data = {
    "email": "user@mediacity.co.in",
    "password": "123456"
}

# Inisialisasi browser Chrome
options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")
driver = webdriver.Chrome(options=options)

try:
    wait = WebDriverWait(driver, 20)

    # Buka halaman utama
    driver.get("https://eclass.mediacity.co.in/demo/public/")

    # Tunggu tombol "Login" terlihat dan klik
    login_button = wait.until(
        EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Login')]"))
    )
    login_button.click()

    # Tunggu hingga form login muncul
    wait.until(
        EC.presence_of_element_located((By.TAG_NAME, "form"))
    )

    # Isi form login
    driver.find_element(By.NAME, "email").send_keys(login_data["email"])
    driver.find_element(By.NAME, "password").send_keys(login_data["password"])

    # Scroll ke tombol login untuk memastikan terlihat
    login_submit_button = driver.find_element(By.XPATH, "//button[@title='Sign In']")
    driver.execute_script("arguments[0].scrollIntoView(true);", login_submit_button)

    # Klik tombol login
    driver.execute_script("arguments[0].click();", login_submit_button)

    # Tunggu hingga halaman dashboard muncul
    dashboard_element = wait.until(
        EC.presence_of_element_located((By.XPATH, "//h4[contains(text(), 'Dashboard')]"))
    )
    print("Login berhasil:", dashboard_element.text)

    # Tunggu agar dropdown profil muncul
    profile_dropdown = wait.until(
        EC.element_to_be_clickable((By.ID, "dropdownMenu1"))
    )

    # Gunakan JavaScript untuk membuka dropdown
    driver.execute_script("arguments[0].scrollIntoView(true);", profile_dropdown)
    driver.execute_script("arguments[0].click();", profile_dropdown)
    print("Dropdown berhasil dibuka")

    # Tunggu agar tombol logout terlihat
    logout_button = wait.until(
        EC.presence_of_element_located((By.XPATH, "//div[@id='notificationFooter' and contains(text(),'Logout')]"))
    )

    # Scroll dan klik tombol logout
    driver.execute_script("arguments[0].scrollIntoView(true);", logout_button)
    driver.execute_script("arguments[0].click();", logout_button)
    print("Logout berhasil!")

    # Tunggu hingga kembali ke halaman login
    wait.until(
        EC.presence_of_element_located((By.XPATH, "//a[contains(text(), 'Login')]"))
    )

except Exception as e:
    print(f"Terjadi kesalahan: {e}")

finally:
    # Tunggu beberapa detik sebelum menutup browser
    time.sleep(5)
    driver.quit()
