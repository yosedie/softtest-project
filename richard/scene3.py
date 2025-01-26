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
class TestHome:
    
    def scroll_to_element(self, element):
        """Helper function to scroll to an element."""
        self.driver.execute_script("arguments[0].scrollIntoView({behavior: 'smooth', block: 'center'});", element)
        
    def test_search(self):
        time.sleep(5)
        search_input = "web"
        search_field = self.driver.find_element(By.CLASS_NAME, "searchTerm")
        time.sleep(5)
        search_field.send_keys(search_input)
        
        time.sleep(5)
        search_button = WebDriverWait(self.driver, 5).until(
            EC.element_to_be_clickable((By.CLASS_NAME, "searchButton"))
        )
        search_button.click()
        time.sleep(5)
        
    def test_home(self):
        header = WebDriverWait(self.driver, 10).until(
            EC.presence_of_element_located((By.XPATH, "/html/body/footer/div[1]/div/div/div[2]/div/div[1]/h2"))
        )
        self.scroll_to_element(header)
        header.click
        
