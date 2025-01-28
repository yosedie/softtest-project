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

    # 7. Klik tombol Wishlist
    wishlist_link = wait.until(
        EC.presence_of_element_located((By.XPATH, "//a[@title='Wishlist']"))
    )
    wishlist_link.click()
    print("Tombol Wishlist diklik.")

    # 8. Tunggu hingga elemen target dimuat
    target_element = wait.until(
        EC.presence_of_element_located((By.XPATH, "//div[@class='col-lg-4 col-md-6 ']"))
    )

    # 9. Scroll ke elemen target
    driver.execute_script("arguments[0].scrollIntoView({ behavior: 'smooth', block: 'center' });", target_element)
    print("Scrolled to target element.")

    # 10. (Opsional) Tambahkan tindakan tambahan, seperti klik atau validasi
    print("Elemen target ditemukan: ", target_element.text)

except Exception as e:
    print(f"Terjadi kesalahan: {e}")

finally:
    # Tunggu sebentar sebelum menutup browser
    time.sleep(5)
    driver.quit()
    print("Browser ditutup.")
