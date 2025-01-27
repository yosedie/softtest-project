from time import time
import subprocess
import sys

def ensure_colorama_installed():
    try:
        import colorama
    except ImportError:
        print("Colorama is not installed. Installing now...")
        subprocess.check_call([sys.executable, "-m", "pip", "install", "colorama"])
        print("Colorama installed successfully.")
    else:
        print("Colorama is already installed.")

def execute_subprocess(script_name):
    try:
        start_time = time()
        result = subprocess.run(['python', script_name], check=True, 
                              capture_output=True, text=True)
        
        elapsed_time = time() - start_time
        print(Fore.GREEN + result.stdout + Fore.RESET)
        print(Fore.GREEN + f"Waktu yang dilalui {elapsed_time:.2f} detik" + Fore.RESET)
        print(Fore.GREEN + f"{script_name} berjalan sukses" + Fore.RESET)
        return result
    except subprocess.CalledProcessError as e:
        print(Fore.RED + f"Gagal menjalankan {script_name}:" + Fore.RESET)
        
        error_lines = e.stderr.split('\n')
        found_selenium_test = False
        line_number = ""
        
        for i, line in enumerate(error_lines):
            err_func_condition = found_selenium_test and line.strip() and not line.startswith("Traceback") and not "self." in line and not "^" in line and not "selenium" in line and not "exceptions" in line
            if "line" in line and ".py" in line and "run_selenium_test" in line:
                print(Fore.YELLOW + line.strip().replace("line", "baris") + Fore.RESET)
                found_selenium_test = True
                try:
                    line_parts = line.split("line ")
                    if len(line_parts) > 1:
                        number_part = line_parts[1].split(",")[0]
                        line_number = ''.join(filter(str.isdigit, number_part))
                except:
                    line_number = "unknown"
            elif err_func_condition:
                if not any(skip in line for skip in ["File", "raise", "subprocess"]):
                    
                    print(Fore.RED + f"{line_number} {line.strip()}" + Fore.RESET)
            elif found_selenium_test and line.strip() and not line.startswith("Traceback") and "selenium" in line and "exceptions" in line :
                
                print(Fore.RED + f"{line.strip()}" + Fore.RESET)
                break


def show_menu():
    menu = """
    Pilih menu untuk testing :
    1 - Download import user PDF [ADMIN]
    2 - Hapus satu user [ADMIN]
    3 - Add User (Random data) [ADMIN]
    4 - Edit User (Random data) [ADMIN]
    5 - Info User [ADMIN]
    6 - Block User [ADMIN]
    7 - Verify User [ADMIN]
    8 - Download excel data verifikasi user [ADMIN]
    9 - Tambah role baru (Nama random, All Access) [ADMIN]
    10 - Download role & permission PDF [ADMIN]
    11 - Tambah instructor plan (Random data) [ADMIN]
    12 - Ubah instructor involve request (Random + Toggle) [ADMIN]
    13 - Download instructor involve request PDF [ADMIN]
    0 - Exit
    Pilihan test > """
    
    while True:
        choice = input(Fore.CYAN + menu + Fore.RESET)
        if choice == "1":
            try:
                with open("./function/downloadPDFImportUser.py", "r") as file:
                    print(Fore.YELLOW + "Membuka downloadPDFImportUser.py..." + Fore.RESET)
                    execute_subprocess("./function/downloadPDFImportUser.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: downloadPDFImportUser.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "2":
            try:
                with open("./function/deleteOneUser.py", "r") as file:
                    print(Fore.YELLOW + "Membuka deleteOneUser.py..." + Fore.RESET)
                    execute_subprocess("./function/deleteOneUser.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: deleteOneUser.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "3":
            try:
                with open("./function/addUser.py", "r") as file:
                    print(Fore.YELLOW + "Membuka addUser.py..." + Fore.RESET)
                    execute_subprocess("./function/addUser.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: addUser.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "4":
            try:
                with open("./function/editUser.py", "r") as file:
                    print(Fore.YELLOW + "Membuka editUser.py..." + Fore.RESET)
                    execute_subprocess("./function/editUser.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: editUser.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "5":
            try:
                with open("./function/infoUser.py", "r") as file:
                    print(Fore.YELLOW + "Membuka infoUser.py..." + Fore.RESET)
                    execute_subprocess("./function/infoUser.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: infoUser.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "6":
            try:
                with open("./function/blockUser.py", "r") as file:
                    print(Fore.YELLOW + "Membuka blockUser.py..." + Fore.RESET)
                    execute_subprocess("./function/blockUser.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: blockUser.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "7":
            try:
                with open("./function/verifyUser.py", "r") as file:
                    print(Fore.YELLOW + "Membuka verifyUser.py..." + Fore.RESET)
                    execute_subprocess("./function/verifyUser.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: verifyUser.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "8":
            try:
                with open("./function/downloadExcelVerifyUser.py", "r") as file:
                    print(Fore.YELLOW + "Membuka downloadExcelVerifyUser.py..." + Fore.RESET)
                    execute_subprocess("./function/downloadExcelVerifyUser.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: downloadExcelVerifyUser.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "9":
            try:
                with open("./function/addNewRole.py", "r") as file:
                    print(Fore.YELLOW + "Membuka addNewRole.py..." + Fore.RESET)
                    execute_subprocess("./function/addNewRole.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: addNewRole.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "10":
            try:
                with open("./function/downloadRoleAndPermission.py", "r") as file:
                    print(Fore.YELLOW + "Membuka downloadRoleAndPermission.py..." + Fore.RESET)
                    execute_subprocess("./function/downloadRoleAndPermission.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: downloadRoleAndPermission.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "11":
            try:
                with open("./function/addInstructorPlan.py", "r") as file:
                    print(Fore.YELLOW + "Membuka addInstructorPlan.py..." + Fore.RESET)
                    execute_subprocess("./function/addInstructorPlan.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: addInstructorPlan.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "12":
            try:
                with open("./function/changeInstructorInvolveRequest.py", "r") as file:
                    print(Fore.YELLOW + "Membuka changeInstructorInvolveRequest.py..." + Fore.RESET)
                    execute_subprocess("./function/changeInstructorInvolveRequest.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: changeInstructorInvolveRequest.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "13":
            try:
                with open("./function/downloadInstructorInvolveRequest.py", "r") as file:
                    print(Fore.YELLOW + "Membuka downloadInstructorInvolveRequest.py..." + Fore.RESET)
                    execute_subprocess("./function/downloadInstructorInvolveRequest.py")
            except FileNotFoundError:
                print(Fore.RED + "Error: downloadInstructorInvolveRequest.py file tidak ditemukan!" + Fore.RESET)
        elif choice == "0":
            print(Fore.YELLOW + "Keluar dari program..." + Fore.RESET)
            break
        else:
            print(Fore.RED + "Pilihan tidak valid!" + Fore.RESET)

if __name__ == "__main__":
    ensure_colorama_installed()
    from colorama import Fore, init
    init(autoreset=True)
    show_menu()
