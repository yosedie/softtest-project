from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.edge.service import Service
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.action_chains import ActionChains
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

    # 2. Tunggu dan klik tombol "Decline Cookies"
    cookie_decline_button = wait.until(
        EC.element_to_be_clickable((By.ID, "cookie-decline"))
    )
    cookie_decline_button.click()
    print("Tombol 'Decline Cookies' diklik.")

    # 3. Klik tombol "Login"
    login_button = wait.until(
        EC.element_to_be_clickable((By.XPATH, "//a[contains(text(), 'Login')]"))
    )
    login_button.click()
    print("Tombol login diklik.")

    # 4. Isi form login
    wait.until(EC.presence_of_element_located((By.NAME, "email"))).send_keys(login_data["email"])
    driver.find_element(By.NAME, "password").send_keys(login_data["password"])
    print("Form login diisi.")

    # 5. Klik tombol "Sign In"
    sign_in_button = driver.find_element(By.XPATH, "//button[@title='Sign In']")
    sign_in_button.click()
    print("Tombol sign in diklik.")

    # 6. Tunggu halaman selesai dimuat dan temukan kolom pencarian
    search_input = wait.until(
        EC.presence_of_element_located((By.CSS_SELECTOR, "input[name='searchTerm']"))
    )
    print("Kolom pencarian ditemukan.")

    # 7. Masukkan teks pencarian "Digital Marketing Course"
    search_term = "Digital Marketing Course"
    search_input.send_keys(search_term)
    search_input.send_keys(Keys.ENTER)
    print(f"Melakukan pencarian untuk: {search_term}")

    # 8. Tunggu hingga diarahkan ke halaman hasil pencarian
    wait.until(
        EC.url_contains("search?searchTerm=Digital+Marketing+Course")
    )
    print("Berhasil diarahkan ke halaman hasil pencarian.")

    # 9. Scroll ke elemen dengan class tertentu
    target_element = wait.until(
        EC.presence_of_element_located((By.CLASS_NAME, "col-lg-4.col-md-6"))
    )
    driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", target_element)
    print("Halaman digulir ke elemen dengan class 'col-lg-4 col-md-6'.")

    # 10. Klik elemen
    time.sleep(2)
    target_element.click()
    print("Elemen dengan class 'col-lg-4 col-md-6' diklik.")

    # 11. Scroll sampai ke bawah halaman
    driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")
    print("Halaman digulir sampai paling bawah.")

    # 12. Tunggu beberapa saat untuk memastikan semua elemen termuat
    time.sleep(2)

    # 13. Klik tombol "Add To Cart"
    add_to_cart_button = wait.until(
        EC.element_to_be_clickable((By.XPATH, "//button[contains(@class, 'btn btn-primary')]"))
    )

    # Gunakan ActionChains untuk memastikan klik tidak terhalang
    actions = ActionChains(driver)
    actions.move_to_element(add_to_cart_button).click().perform()
    print("Tombol 'Add To Cart' diklik.")

    # 14. Tunggu hingga pesan berhasil muncul
    wait.until(
        EC.presence_of_element_located((By.XPATH, "//*[contains(text(), 'flash.CartAddedWithLink')]"))
    )
    print("Pesan 'flash.CartAddedWithLink' ditemukan di halaman.")

    # 15. Tunggu halaman detail terbuka (opsional)
    time.sleep(3)
    print("Test case selesai.")

except Exception as e:
    print(f"Terjadi kesalahan: {e}")

finally:
    # Tunggu sebentar sebelum menutup browser
    time.sleep(5)
    driver.quit()
    print("Browser ditutup.")
