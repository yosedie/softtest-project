# from selenium import webdriver
# from selenium.webdriver.common.by import By
# from selenium.webdriver.edge.service import Service
# from selenium.webdriver.support.ui import WebDriverWait
# from selenium.webdriver.support import expected_conditions as EC
# from webdriver_manager.microsoft import EdgeChromiumDriverManager
# from selenium.webdriver.common.action_chains import ActionChains
# import time

# # Data login pengguna
# login_data = {
#     "email": "user@mediacity.co.in",
#     "password": "123456"
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

#     # 2. Tunggu dan klik tombol "Allow cookies" jika muncul
#     try:
#         cookie_button = wait.until(
#             EC.element_to_be_clickable((By.ID, "cookie-decline"))
#         )
#         cookie_button.click()
#         print("Tombol 'Allow cookies' diklik.")
#     except Exception as e:
#         print("Tombol 'Allow cookies' tidak ditemukan atau tidak muncul:", e)

#     # 3. Klik tombol "Login"
#     login_button = wait.until(
#         EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Login')]"))
#     )
#     login_button.click()
#     print("Tombol login diklik.")

#     # 4. Tunggu form login muncul
#     wait.until(EC.presence_of_element_located((By.NAME, "email")))

#     # 5. Isi form login
#     driver.find_element(By.NAME, "email").send_keys(login_data["email"])
#     driver.find_element(By.NAME, "password").send_keys(login_data["password"])
#     print("Form login diisi.")

#     # 6. Centang kotak "Remember Me"
#     remember_checkbox = driver.find_element(By.ID, "remember")
#     if not remember_checkbox.is_selected():
#         remember_checkbox.click()
#     print("Checkbox 'Remember Me' dicentang.")

#     # 7. Klik tombol "Login"
#     login_submit_button = wait.until(
#         EC.element_to_be_clickable((By.XPATH, "//button[contains(@class, 'btn-primary') and contains(text(), 'Login')]"))
#     )
#     login_submit_button.click()
#     print("Tombol login diklik.")

#     # 8. Tunggu hingga halaman home dimuat
#     home_element = wait.until(
#         EC.presence_of_element_located((By.XPATH, "//h1[contains(text(), 'Welcome')]"))
#     )
#     print("Berhasil login dan masuk ke halaman:", home_element.text)
    
#     # 9. Buka dropdown gambar profil pengguna
#     print("Mencoba membuka dropdown...")

#     # Klik menggunakan JavaScript untuk membuka dropdown
#     try:
#         user_image = wait.until(
#             EC.element_to_be_clickable((By.CSS_SELECTOR, "img[alt='user']"))
#         )
#         driver.execute_script("arguments[0].click();", user_image)
#         print("Dropdown dibuka menggunakan JavaScript.")
#     except Exception as e:
#         print("Gagal membuka dropdown:", e)

#     # 10. Tunggu hingga elemen logout muncul di dropdown
#     logout_button = wait.until(
#         EC.presence_of_element_located((By.XPATH, "//a[contains(@href, 'logout')]"))
#     )
    
#     # Klik tombol logout
#     driver.execute_script("arguments[0].click();", logout_button)
#     print("Logout berhasil.")

#     # 11. Tunggu hingga kembali ke halaman utama
#     wait.until(
#         EC.presence_of_element_located((By.XPATH, "//a[contains(text(), 'Login')]"))
#     )
#     print("Kembali ke halaman utama setelah logout.")

# except Exception as e:
#     print(f"Terjadi kesalahan: {e}")

# finally:
#     # Tunggu sebentar sebelum menutup browser
#     time.sleep(5)
#     driver.quit()
#     print("Browser ditutup.")
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.edge.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.microsoft import EdgeChromiumDriverManager
import time

# Data login pengguna
login_data = {
    "email": "user@mediacity.co.in",
    "password": "123456"
}

# Inisialisasi driver Edge
options = webdriver.EdgeOptions()
options.add_argument("--start-maximized")
driver = webdriver.Edge(service=Service(EdgeChromiumDriverManager().install()), options=options)

try:
    wait = WebDriverWait(driver, 30)  # Waktu tunggu eksplisit

    # 1. Buka halaman utama
    driver.get("https://eclass.mediacity.co.in/demo/public/")
    print("Berhasil membuka halaman utama.")

    # 2. Klik tombol "Login"
    login_button = wait.until(
        EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Login')]"))
    )
    login_button.click()
    print("Tombol login diklik.")

    # 3. Isi form login
    wait.until(EC.presence_of_element_located((By.NAME, "email"))).send_keys(login_data["email"])
    driver.find_element(By.NAME, "password").send_keys(login_data["password"])
    print("Form login diisi.")

    # 4. Klik tombol "Sign In"
    sign_in_button = driver.find_element(By.XPATH, "//button[@title='Sign In']")
    sign_in_button.click()
    print("Tombol sign in diklik.")

    # 5. Tunggu halaman selesai dimuat (periksa elemen dropdown user)
    dropdown_user = wait.until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "div.dropdown"))
    )
    print("Dropdown USER ditemukan.")

    # 6. Klik dropdown USER
    dropdown_user.click()
    print("Dropdown USER dibuka.")

    # 7. Cari tombol Logout
    logout_link = wait.until(
        EC.presence_of_element_located((By.XPATH, "//a[@title='Logout']"))
    )
    print("Tombol logout ditemukan.")

    # 8. Eksekusi JavaScript untuk submit form logout
    driver.execute_script("document.getElementById('logout-form').submit();")
    print("Logout berhasil dieksekusi.")

    # 9. Tunggu hingga kembali ke halaman utama
    wait.until(
        EC.presence_of_element_located((By.XPATH, "//a[contains(text(), 'Login')]"))
    )
    print("Kembali ke halaman utama setelah logout.")

except Exception as e:
    print(f"Terjadi kesalahan: {e}")

finally:
    # Tunggu sebentar sebelum menutup browser
    time.sleep(5)
    driver.quit()
    print("Browser ditutup.")
