from selenium import webdriver
from selenium.webdriver.edge.options import Options
from selenium.webdriver.edge.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.microsoft import EdgeChromiumDriverManager
import pytest
import time


@pytest.fixture(scope="class")
def setup(request):
    """Setup untuk mengonfigurasi driver Edge dan membuka halaman utama."""
    options = Options()
    service = Service(EdgeChromiumDriverManager().install())
    driver = webdriver.Edge(service=service, options=options)

    try:
        driver.get("https://eclass.mediacity.co.in/demo/public/")
        driver.maximize_window()
        request.cls.driver = driver
        yield
    except Exception as e:
        print(f"An error occurred during setup: {e}")
    finally:
        driver.quit()


@pytest.mark.usefixtures("setup")
class TestBlog:
    def test_bukaBlog(self):
        """Mengklik tautan blog untuk membuka halaman blog."""
        try:
            blog_link = WebDriverWait(self.driver, 20).until(
                EC.element_to_be_clickable((By.LINK_TEXT, "Blog"))
            )
            blog_link.click()
            time.sleep(5)
            assert "blog" in self.driver.current_url, "Halaman blog tidak terbuka."
            print("Berhasil membuka halaman blog!")
        except Exception as e:
            print(f"Error in test_bukaBlog: {e}")

    def test_nextpage(self):
        """Klik tombol untuk menuju halaman berikutnya dan tunggu hingga halaman diload."""
        try:
            # Tunggu elemen pagination muncul
            nextpage_link = WebDriverWait(self.driver, 20).until(
                EC.presence_of_element_located((By.LINK_TEXT, "2"))
            )

            # Cek apakah tombol halaman 2 sudah aktif
            is_active = "active" in nextpage_link.get_attribute("class")
            if is_active:
                print("Sudah berada di halaman 2. Tes selesai.")
                return  # Keluar dari tes jika sudah di halaman 2

            # Jika belum di halaman 2, klik tombol "2"
            self.driver.execute_script(
                "arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", nextpage_link
            )
            time.sleep(2)
            nextpage_link.click()

            # Tunggu hingga halaman selesai dimuat (misalnya, elemen baru muncul di halaman 2)
            WebDriverWait(self.driver, 20).until(
                EC.presence_of_element_located((By.CLASS_NAME, "blog-section"))  # Elemen yang ada di halaman 2
            )

            # Verifikasi apakah URL sekarang di halaman 2
            assert "page=2" in self.driver.current_url, "Halaman tidak berpindah ke halaman 2."
            print("Berhasil berpindah ke halaman 2!")
        except Exception as e:
            print(f"Error in test_nextpage: {e}")
