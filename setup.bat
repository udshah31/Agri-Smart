@echo off
REM ============================================
REM AgriSmart - Quick Setup Script for Windows
REM Run this on a fresh Windows machine to set up everything
REM Usage: Double-click setup.bat or run from Command Prompt
REM ============================================

echo.
echo 🌾 ==================================
echo    AgriSmart - Windows Setup Script
echo 🌾 ==================================
echo.

REM --- Check PHP ---
echo [1/6] Checking PHP...
where php >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    php -v | findstr /R "^PHP"
    echo    [OK] PHP found.
) else (
    echo    [ERROR] PHP not found!
    echo    Install XAMPP from https://www.apachefriends.org/
    echo    Then add C:\xampp\php to your system PATH.
    echo.
    echo    To add to PATH:
    echo    1. Press Win+R, type "sysdm.cpl", press Enter
    echo    2. Advanced tab ^> Environment Variables
    echo    3. Under System Variables, select "Path" ^> Edit
    echo    4. Add: C:\xampp\php
    echo    5. Click OK, then restart this terminal
    pause
    exit /b 1
)

REM --- Check MySQL ---
echo [2/6] Checking MySQL...
where mysql >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    mysql --version
    echo    [OK] MySQL found.
) else (
    echo    [WARNING] MySQL CLI not found.
    echo    XAMPP users: That's OK, use phpMyAdmin instead.
    echo    To use CLI, add C:\xampp\mysql\bin to your system PATH.
)

REM --- Check Python ---
echo [3/6] Checking Python...
where python >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    python --version
    echo    [OK] Python found.
) else (
    echo    [ERROR] Python not found!
    echo    Install from https://www.python.org/downloads/
    echo    IMPORTANT: Check "Add Python to PATH" during installation!
    pause
    exit /b 1
)

REM --- Setup Python Virtual Environment ---
echo [4/6] Setting up Python virtual environment...
if not exist "venv" (
    python -m venv venv
    echo    [OK] Created venv\
) else (
    echo    [OK] venv\ already exists
)

echo [5/6] Installing Python dependencies...
venv\Scripts\pip.exe install --quiet -r requirements.txt
echo    [OK] Installed: pandas, numpy, matplotlib, scikit-learn, joblib

REM --- Verify ML works ---
echo [6/6] Verifying ML libraries...
venv\Scripts\python.exe -c "import sklearn, pandas, numpy; print('   [OK] All ML libraries working')"

echo.
echo ============================================
echo    Database Setup Instructions
echo ============================================
echo.
echo If MySQL CLI is available, run these commands:
echo.
echo    mysql -u root -p -e "CREATE DATABASE ecometrics;"
echo    mysql -u root -p ecometrics ^< "database\ecometrics (3).sql"
echo.
echo Or use phpMyAdmin:
echo    1. Open http://localhost/phpmyadmin
echo    2. Create database: ecometrics
echo    3. Import: database\ecometrics (3).sql
echo.

echo.
echo 🌾 ==================================
echo    Setup Complete!
echo 🌾 ==================================
echo.
echo To start the application, run:
echo.
echo    php -S localhost:8035
echo.
echo Then open: http://localhost:8035
echo.
pause
