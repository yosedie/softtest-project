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
    options = Options()
    service = Service(EdgeChromiumDriverManager().install())
    driver = webdriver.Edge(service=service, options=options)

    try:
        driver.get("https://eclass.mediacity.co.in/demo/public/")
        driver.maximize_window()
        request.cls.driver = driver
        yield
    except Exception as e:
        print(f"An error occurred: {e}")
    finally:
        driver.quit()
        
@pytest.mark.usefixtures("setup")
class TestBlog:
    def test_bukaBlog(self):
        blog_link = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.LINK_TEXT, "Blog"))
        )
        blog_link.click()
        
        time.sleep(5)
        
    def test_nextpage(self):
        nextpage_link = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.LINK_TEXT, "2"))
        )
        self.driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", nextpage_link)
        time.sleep(5)
        nextpage_link.click()
        time.sleep(5)
        
    def test_bukalink(self):
        read_link = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.LINK_TEXT, "Blogging Courses..."))
        )
        time.sleep(5)
        self.driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", read_link)
        time.sleep(5)
        read_link.click()
        time.sleep(5)
        
    def test_bukaothers(self):
        other_link = WebDriverWait(self.driver, 10).until(
            EC.element_to_be_clickable((By.LINK_TEXT, "Seas accumsan nulla nec lacus ultricies placerat."))
        )
        time.sleep(5)
        self.driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", other_link)
        time.sleep(5)
        other_link.click()
        time.sleep(5)
        
