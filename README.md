# 🌾 AgriSmart – Smart Agriculture Management System

An intelligent agriculture web application that combines **ML-powered predictions**, **IoT monitoring**, and **real-time analytics** to empower farmers with digital tools for better crop and resource management.

## 📸 Screenshots

| Homepage | Dashboard | Crop Recommendation |
|----------|-----------|---------------------|
| ![homepage](https://github.com/user-attachments/assets/9b40d736-5848-4891-8f52-8d6e2936b4d5) | ![about](https://github.com/user-attachments/assets/58cdacb0-1662-4856-bcba-e29c2b0c5d85) | ![crop recommendation](https://github.com/user-attachments/assets/8299df57-5e48-4442-9687-6285da989a36) |

---

## 🚀 Quick Start (Setup on a New Machine)

### Prerequisites

| Software | Version | Download |
|----------|---------|----------|
| **PHP** | 8.0+ | [php.net](https://www.php.net/downloads) |
| **MySQL / MariaDB** | 5.7+ / 10.4+ | [mysql.com](https://dev.mysql.com/downloads/) or [XAMPP](https://www.apachefriends.org/) |
| **Python** | 3.9+ | [python.org](https://www.python.org/downloads/) |
| **Git** | any | [git-scm.com](https://git-scm.com/) |

> **Easiest Option:** Install [XAMPP](https://www.apachefriends.org/) which bundles PHP + MySQL + phpMyAdmin in one installer. Available for **Windows, macOS, and Linux**.

---

### 🍎 macOS / Linux Setup

<details>
<summary><strong>Click to expand macOS / Linux instructions</strong></summary>

#### Step 1: Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/AgriSmart-main.git
cd AgriSmart-main
```

#### Step 2: Automated Setup (Recommended)

Run the setup script to automatically check prerequisites, create the virtual environment, install dependencies, and set up the database:

```bash
bash setup.sh
```

The script will prompt for your MySQL credentials and handle everything automatically.

#### Step 3: Manual Setup (Alternative)

If you prefer to set things up manually, follow these steps:

**a) Set Up the Database**

1. Start MySQL (or start XAMPP and enable MySQL):
   ```bash
   # Homebrew (Mac):
   brew services start mysql
   # Linux:
   sudo systemctl start mysql
   ```

2. Create the database:
   ```bash
   mysql -u root -p -e "CREATE DATABASE ecometrics;"
   ```

3. Import the schema (creates all 10 tables with sample data):
   ```bash
   mysql -u root -p ecometrics < database/ecometrics\ \(3\).sql
   ```

   **Or using phpMyAdmin:**
   - Open `http://localhost/phpmyadmin`
   - Create a new database named `ecometrics`
   - Go to **Import** → Select `database/ecometrics (3).sql` → Click **Go**

**b) Configure Database Credentials**

Edit `db.php` if your MySQL credentials differ:

```php
$host = 'localhost';
$dbname = 'ecometrics';
$username = 'root';       // ← Change if needed
$password = '';            // ← Change if needed (XAMPP default is empty)
```

> **Note:** Several other files also contain inline DB credentials. If your password is not empty, also update:
> `smart-irrigation.php`, `waste-mgt.php`, `contactus.php`, `get_ph.php`, `get_recommendation.php`, `display_weather.php`, `fetch_weather.php`, `qna_system.php`, `contactlist.php`

**c) Set Up Python Virtual Environment**

```bash
# Create virtual environment
python3 -m venv venv

# Activate it
source venv/bin/activate

# Install ML dependencies
pip install -r requirements.txt
```

**Verify Python works:**
```bash
venv/bin/python -c "import sklearn; print('scikit-learn OK:', sklearn.__version__)"
```

#### Step 4: Run the Application

**Option A: PHP Built-in Server (simplest)**
```bash
php -S localhost:8035
```
Then open your browser to: **http://localhost:8035**

**Option B: XAMPP / Apache**
1. Copy (or symlink) the `AgriSmart-main` folder into your XAMPP `htdocs/` directory
2. Start Apache and MySQL from the XAMPP Control Panel
3. Open: **http://localhost/AgriSmart-main**

</details>

---

### 🪟 Windows Setup

<details>
<summary><strong>Click to expand Windows instructions</strong></summary>

#### Step 1: Install Prerequisites

| Software | How to Install |
|----------|---------------|
| **XAMPP** | Download from [apachefriends.org](https://www.apachefriends.org/) → Run the installer → Install to `C:\xampp` (default) |
| **Python 3.9+** | Download from [python.org](https://www.python.org/downloads/) → **✅ Check "Add Python to PATH"** during installation |
| **Git** | Download from [git-scm.com](https://git-scm.com/download/win) → Use default options during installation |

> ⚠️ **Critical:** When installing Python, you **must** check the **"Add Python to PATH"** checkbox on the first installer screen. If you missed it, uninstall and reinstall Python with this option enabled.

**Add PHP and MySQL to your System PATH:**

XAMPP does not automatically add PHP and MySQL to your system PATH. To use `php` and `mysql` from the Command Prompt:

1. Press **Win + R**, type `sysdm.cpl`, press **Enter**
2. Go to the **Advanced** tab → Click **Environment Variables**
3. Under **System Variables**, find `Path` → Click **Edit**
4. Click **New** and add these two entries:
   ```
   C:\xampp\php
   C:\xampp\mysql\bin
   ```
5. Click **OK** on all dialogs
6. **Close and reopen** any Command Prompt windows for changes to take effect

**Verify everything is on PATH** (open a **new** Command Prompt):
```cmd
php -v
python --version
git --version
mysql --version
```

#### Step 2: Clone the Repository

Open **Command Prompt** (or **Git Bash**):

```cmd
git clone https://github.com/YOUR_USERNAME/AgriSmart-main.git
cd AgriSmart-main
```

> **Tip:** If using XAMPP, you can clone directly into `C:\xampp\htdocs\`:
> ```cmd
> cd C:\xampp\htdocs
> git clone https://github.com/YOUR_USERNAME/AgriSmart-main.git
> ```

#### Step 3: Automated Setup (Recommended)

Double-click **`setup.bat`** or run it from Command Prompt:

```cmd
setup.bat
```

This will:
- ✅ Check that PHP, Python, and MySQL are installed
- ✅ Create a Python virtual environment (`venv\`)
- ✅ Install all ML dependencies (pandas, numpy, scikit-learn, etc.)
- ✅ Verify that ML libraries load correctly
- ✅ Display database import instructions

#### Step 4: Manual Setup (Alternative)

If you prefer manual steps or the batch script encounters issues:

**a) Set Up the Database**

1. Open the **XAMPP Control Panel** and start **MySQL**

2. **Using phpMyAdmin (easiest on Windows):**
   - Open your browser to `http://localhost/phpmyadmin`
   - Click **New** (left sidebar) to create a new database
   - Enter database name: `ecometrics` → Click **Create**
   - Click the `ecometrics` database → Go to **Import** tab
   - Click **Choose File** → Navigate to `database\ecometrics (3).sql`
   - Click **Go** at the bottom

3. **Using Command Prompt (alternative):**
   ```cmd
   mysql -u root -p -e "CREATE DATABASE ecometrics;"
   mysql -u root -p ecometrics < "database\ecometrics (3).sql"
   ```

**b) Configure Database Credentials**

Edit `db.php` if your MySQL credentials differ:

```php
$host = 'localhost';
$dbname = 'ecometrics';
$username = 'root';       // ← Change if needed
$password = '';            // ← Change if needed (XAMPP default is empty)
```

> **Note:** Several other files also contain inline DB credentials. If your password is not empty, also update:
> `smart-irrigation.php`, `waste-mgt.php`, `contactus.php`, `get_ph.php`, `get_recommendation.php`, `display_weather.php`, `fetch_weather.php`, `qna_system.php`, `contactlist.php`

**c) Set Up Python Virtual Environment**

```cmd
:: Create virtual environment
python -m venv venv

:: Activate it
venv\Scripts\activate

:: Install ML dependencies
pip install -r requirements.txt
```

**Verify Python works:**
```cmd
venv\Scripts\python.exe -c "import sklearn; print('scikit-learn OK:', sklearn.__version__)"
```

**d) Update Python Paths for Windows**

The ML PHP files reference `venv/bin/python` (macOS/Linux path). On Windows, you need to update them to use `venv\\Scripts\\python.exe`. Update the Python path in these files:

| File | Find | Replace with |
|------|------|-------------|
| `crop_recommendation.php` | `venv/bin/python` | `venv\\Scripts\\python.exe` |
| `fertilizer_recommendation.php` | `venv/bin/python` | `venv\\Scripts\\python.exe` |
| `yield_prediction.php` | `venv/bin/python` | `venv\\Scripts\\python.exe` |
| `crop_prediction.php` | `venv/bin/python` | `venv\\Scripts\\python.exe` |
| `rainfall_prediction.php` | `venv/bin/python` | `venv\\Scripts\\python.exe` |

> **Tip:** You can use **Find and Replace** (Ctrl+H) in any text editor to replace all occurrences of `venv/bin/python` with `venv\\Scripts\\python.exe` across these files.

#### Step 5: Run the Application

**Option A: PHP Built-in Server (simplest)**

Open Command Prompt in the project directory:
```cmd
php -S localhost:8035
```
Then open your browser to: **http://localhost:8035**

> **Note:** Keep the Command Prompt window open while using the app. Press `Ctrl+C` to stop the server.

**Option B: XAMPP / Apache (recommended for Windows)**

1. Copy the `AgriSmart-main` folder into `C:\xampp\htdocs\` (or clone directly there as shown above)
2. Open the **XAMPP Control Panel**
3. Start both **Apache** and **MySQL**
4. Open your browser to: **http://localhost/AgriSmart-main**

> 💡 **Tip:** If Apache doesn't start, it's usually because port 80 is in use by another program (like Skype or IIS). In XAMPP, click **Config** next to Apache → Open `httpd.conf` → Change `Listen 80` to `Listen 8080`, then access the app at `http://localhost:8080/AgriSmart-main`.

</details>

---

### ✅ Step 6: Verify Everything Works (All Platforms)

Open your browser and test each page:

| # | URL | What to verify |
|---|-----|---------------|
| 1 | `/index.php` | Homepage loads with navbar |
| 2 | `/signup.php` | Create a new account |
| 3 | `/login.php` | Login with your new account |
| 4 | `/dashboard.php` | Welcome message shows your username |
| 5 | `/crop_recommendation.php` | Submit form → ML returns crop name |
| 6 | `/fertilizer_recommendation.php` | Form loads properly |
| 7 | `/yield_prediction.php` | Form loads properly |
| 8 | `/crop_prediction.php` | Select state/district/season → predicts crops |
| 9 | `/rainfall_prediction.php` | Select region/month → predicts rainfall |
| 10 | `/soil_health.php` | IoT pH monitor |
| 11 | `/smart-irrigation.php` | IoT moisture/temp dashboard |
| 12 | `/waste-mgt.php` | Dustbin status grid |
| 13 | `/newspaper.php` | Agriculture news via API |
| 14 | `/aboutus.php` | About page with images |
| 15 | `/contactus.php` | Contact form |

---

## 📁 Project Structure

```
AgriSmart-main/
│
├── index.php                    # Landing page
├── login.php / signup.php       # Authentication
├── logout.php                   # Session destroy
├── dashboard.php                # User dashboard (post-login)
│
├── crop_recommendation.php      # ML: Best crop recommendation
├── fertilizer_recommendation.php # ML: Fertilizer suggestion
├── yield_prediction.php         # ML: Yield estimation
├── crop_prediction.php          # ML: Crops for region/season
├── rainfall_prediction.php      # ML: Rainfall forecast
│
├── soil_health.php              # IoT: Real-time pH monitor
├── smart-irrigation.php         # IoT: Moisture + motor control
├── waste-mgt.php                # IoT: Dustbin fill levels
├── newspaper.php                # News API integration
│
├── aboutus.php / contactus.php  # Info pages
├── header.php                   # Shared <head> (CSS/JS imports)
├── navbar.php                   # Shared navigation bar
├── footer.php                   # Shared footer + Bootstrap JS
├── db.php                       # Database connection (PDO)
├── styles.css                   # Glassmorphic design system
│
├── ML/                          # Python ML models
│   ├── crop_prediction/
│   ├── crop_recommendation/
│   ├── fertilizer_recommendation/
│   ├── rainfall_prediction/
│   └── yield_prediction/
│
├── assets/
│   ├── css/                     # Vendor CSS (Bootstrap, etc.)
│   ├── fonts/                   # Web fonts
│   ├── icons/                   # Social media icons
│   ├── img/                     # All images
│   └── js/                      # Vendor JS + dropdown helpers
│
├── database/
│   └── ecometrics (3).sql       # Full database schema + data
│
├── docs/                        # Documentation & screenshots
├── Notebooks/                   # Jupyter notebooks for ML
├── venv/                        # Python virtual environment
├── requirements.txt             # Python dependencies
├── setup.sh                     # Automated setup (macOS/Linux)
├── setup.bat                    # Automated setup (Windows)
└── README.md                    # This file
```

---

## 🛠 Tech Stack

| Layer | Technology |
|-------|-----------|
| **Frontend** | HTML5, CSS3, JavaScript, Bootstrap 4.3 |
| **Backend** | PHP 8.x |
| **Database** | MySQL / MariaDB |
| **ML Engine** | Python 3.12, scikit-learn, pandas, numpy |
| **Design** | Custom Glassmorphic UI (styles.css) |
| **Icons** | FontAwesome 5 |
| **Fonts** | Outfit + Inter (Google Fonts) |

---

## 🔧 Troubleshooting

| Problem | Platform | Solution |
|---------|----------|----------|
| **"Connection failed"** error | All | MySQL is not running. Start it via XAMPP or `mysql.server start` (Mac) / `sudo systemctl start mysql` (Linux) |
| **ML prediction returns blank** | Mac/Linux | Check `venv/bin/python` path exists. Run `python3 -m venv venv` if missing |
| **ML prediction returns blank** | Windows | Check `venv\Scripts\python.exe` path exists. Also verify the PHP files use `venv\\Scripts\\python.exe` (not `venv/bin/python`) |
| **Broken images** | All | All images should be in `assets/img/`. Check file paths |
| **Dropdown menus don't work** | All | Clear browser cache (Ctrl+Shift+R). The navbar uses custom JS, not Bootstrap |
| **PHP not found** | Mac | Install via `brew install php` or use XAMPP |
| **PHP not found** | Windows | Install XAMPP and add `C:\xampp\php` to your system PATH (see Windows setup instructions) |
| **`python` / `python3` not found** | Windows | Reinstall Python and check **"Add Python to PATH"**. Or manually add the Python install folder to your system PATH |
| **Port 8035 in use** | All | Change port: `php -S localhost:8080` and open that URL instead |
| **Apache won't start (XAMPP)** | Windows | Port 80 may be in use by Skype, IIS, or another program. Change Apache's listen port in `httpd.conf` to 8080 |
| **Windows Firewall popup** | Windows | Click **Allow access** when prompted — PHP's built-in server needs network permissions |
| **News page shows error** | All | The News API key may have expired. Get a new one at [newsapi.org](https://newsapi.org) and update `newspaper.php` |

---

## 👥 Team Members

- 
- 
- 
- 
- 

---

## 📄 License

This project is for educational purposes.
