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

    # Tunggu hingga elemen dengan icon "Blog" tersedia
    try:
        # Tunggu elemen link atau ikon yang sesuai
        blog_link = wait.until(EC.presence_of_element_located((By.XPATH, "//a[@href='https://eclass.mediacity.co.in/demo/public/blog']")))
        
        # Debugging untuk memeriksa elemen ditemukan atau tidak
        print(blog_link.get_attribute('outerHTML'))
        
        # Klik elemen dengan JavaScript jika Selenium biasa tidak berhasil
        driver.execute_script("arguments[0].click();", blog_link)
        print("Berhasil menekan ikon Blog.")
    except TimeoutException as e:
        print("Timeout: Tidak menemukan elemen Blog.")
    except Exception as e:
        print(f"Error: {e}")

    time.sleep(2)
    # Tunggu hingga elemen "Add Post" tersedia
    try:
        add_post_button = wait.until(EC.presence_of_element_located((By.XPATH, "//a[@href='https://eclass.mediacity.co.in/demo/public/blog/create']")))
        
        # Gulir ke elemen jika diperlukan
        driver.execute_script("arguments[0].scrollIntoView(true);", add_post_button)
        
        # Debugging untuk memeriksa elemen
        print(add_post_button.get_attribute('outerHTML'))
        
        # Klik tombol dengan JavaScript sebagai alternatif
        driver.execute_script("arguments[0].click();", add_post_button)
        print("Tombol 'Add Post' berhasil ditekan.")
    except TimeoutException as e:
        print("Timeout: Tidak menemukan elemen 'Add Post'.")
    except Exception as e:
        print(f"Error: {e}")
    time.sleep(2)
    try:
        # Tunggu hingga form terlihat
        wait.until(EC.presence_of_element_located((By.XPATH, "//input[@id='heading']")))
        
        # Isi Heading
        heading_field = driver.find_element(By.ID, "heading")
        heading_field.send_keys("My New Blog Post0")

        # Isi Slug
        slug_field = driver.find_element(By.ID, "slug")
        slug_field.send_keys("my-new-blog-post0")

        # Isi Button Text
        button_text_field = driver.find_element(By.NAME, "text")
        button_text_field.send_keys("Read More0")

        # Pilih Tanggal (format MM/DD/YYYY)
        date_field = driver.find_element(By.ID, "inputDate")
        date_field.clear()  # Bersihkan input jika ada nilai default
        date_field.send_keys("01/27/2025")  # Masukkan tanggal dalam format MM/DD/YYYY
        
        # Upload Gambar (sesuaikan path file gambar di lokal)
        image_field = driver.find_element(By.ID, "inputGroupFile01")
        image_field.send_keys(r"C:\test.jpg")  # Ubah dengan path file lokal gambar Anda
        
        # Switch to the iframe that contains the TinyMCE editor
        iframe = driver.find_element(By.ID, "detail_ifr")
        driver.switch_to.frame(iframe)

        # Once inside the iframe, locate the editor's body and perform actions (e.g., typing text)
        editor_body = driver.find_element(By.CSS_SELECTOR, "body")
        editor_body.send_keys("This is a detailed description of my new blog post.0")
        
        # Keluar dari iframe setelah mengisi deskripsi
        driver.switch_to.default_content()
        time.sleep(1)
        # Klik Tombol Create
        create_button = driver.find_element(By.XPATH, "//button[@type='submit' and contains(text(), 'Create')]")
        create_button.click()

        print("Form berhasil diisi dan disubmit.")
    except Exception as e:
        print(f"Terjadi error: {e}")


    # Menunggu agar dropdown benar-benar muncul
    profile_dropdown = wait.until(EC.visibility_of_element_located((By.XPATH, "//span[contains(text(),'Hi instructor')]")))
    # Menggunakan JavaScript untuk membuka dropdown
    time.sleep(2)
    driver.execute_script("arguments[0].click();", profile_dropdown)
    time.sleep(2)
    # Klik logout dengan JavaScript
    logout_button = wait.until(EC.element_to_be_clickable((By.XPATH, "//a[contains(text(),'Logout')]")))
    time.sleep(2)
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
