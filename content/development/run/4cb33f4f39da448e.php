<h1>Автозагрузка програм (как и откуда?)</h1>
<div class="date">01.01.2007</div>


<p>По материалам: <a href="https://www.tlsecurity.net/auto.html" target="_blank">https://www.tlsecurity.net/auto.html</a></p>
<p>1. Autostart folder</p>
<p>C:\windows\start menu\programs\startup {english}</p>
<p>This Autostart Directory is saved in :</p>
<p>[HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\Shell Folders]</p>
<p>Startup="C:\windows\start menu\programs\startup"</p>
<p>[HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\User Shell Folders]</p>
<p>Startup="C:\windows\start menu\programs\startup"</p>
<p>[HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\explorer\User Shell Folders]</p>
<p>"Common Startup"="C:\windows\start menu\programs\startup"</p>
<p>[HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\explorer\Shell Folders]</p>
<p>"Common Startup"="C:\windows\start menu\programs\startup"</p>
<p>By setting it to anything other then C:\windows\start menu\programs\startup will lead to execution of ALL and EVERY executable inside set directory.</p>
<p>2. Win.ini</p>
<p>[windows]</p>
<p>load=file.exe</p>
<p>run=file.exe</p>
<p>3. System.ini</p>
<p>[boot]</p>
<p>Shell=Explorer.exe file.exe</p>
<p>4. c:\windows\winstart.bat</p>
<p> 'Note behaves like an usual BAT file. Used for copying deleting specific files. Autostarts everytime.</p>
<p>5. Registry</p>
<p>[HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\RunServices]</p>
<p>    "Whatever"="c:\runfolder\program.exe"</p>
<p>[HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\RunServicesOnce]</p>
<p>    "Whatever"="c:\runfolder\program.exe"</p>
<p>[HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\Run]</p>
<p>    "Whatever"="c:\runfolder\program.exe"</p>
<p>[HKEY_LOCAL_MACHINE\Software\Microsoft\Windows\CurrentVersion\RunOnce]</p>
<p>    "Whatever"="c:\runfolder\program.exe"</p>
<p>[HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows\CurrentVersion\RunOnceEx\000x]</p>
<p>    "RunMyApp"="||notepad.exe"</p>
<p>    The format is: "DllFileName|FunctionName|CommandLineArguements" -or- "||command parameters"</p>
<p>    Microsoft Windows 98 Microsoft</p>
<p>    Windows 2000 Professional</p>
<p>    Microsoft Windows 2000 Server</p>
<p>    Microsoft Windows 2000 Advanced Server</p>
<p>    Microsoft Windows Millennium Edition</p>
<p>    http://support.microsoft.com/support/kb/articles/Q232/5/09.ASP</p>
<p>[HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Run]</p>
<p>    "Whatever"="c:\runfolder\program.exe"</p>
<p>[HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\RunOnce]</p>
<p>    "Whatever"="c:\runfolder\program.exe"</p>
<p>6. c:\windows\wininit.ini</p>
<p>'Often Used by Setup-Programs when the file exists it is run ONCE and then is deleted by windows</p>
<p>Example content of wininit.ini :</p>
<p>[Rename]</p>
<p>NUL=c:\windows\picture.exe</p>
<p>' This example sends c:\windows\picture.exe to NUL, which means that it is being deleted. This requires no interactivity with the user and runs totaly stealth.</p>
<p>7. Autoexec.bat</p>
<p> Starts everytime at Dos Level.</p>
<p>8. Registry Shell Spawning</p>
<p>[HKEY_CLASSES_ROOT\exefile\shell\open\command] @="%1" %*</p>
<p>[HKEY_CLASSES_ROOT\comfile\shell\open\command] @="%1" %*</p>
<p>[HKEY_CLASSES_ROOT\batfile\shell\open\command] @="%1" %*</p>
<p>[HKEY_CLASSES_ROOT\htafile\Shell\Open\Command] @="%1" %* [HKEY_CLASSES_ROOT\piffile\shell\open\command] @="%1" %*</p>
<p>[HKEY_LOCAL_MACHINE\Software\CLASSES\batfile\shell\open\command] @="%1" %*</p>
<p>[HKEY_LOCAL_MACHINE\Software\CLASSES\comfile\shell\open\command] @="%1" %*</p>
<p>[HKEY_LOCAL_MACHINE\Software\CLASSES\exefile\shell\open\command] @="%1" %*</p>
<p>[HKEY_LOCAL_MACHINE\Software\CLASSES\htafile\Shell\Open\Command] @= "%1" %*</p>
<p>[HKEY_LOCAL_MACHINE\Software\CLASSES\piffile\shell\open\command] @="%1" %*</p>
<p>The key should have a value of Value &lt;"%1" %*&gt;, if this is changed to &lt;server.exe "%1 %*"&gt;, the server.exe is executed EVERYTIME an exe/pif/com/bat/hta is executed.</p>
<p>Known as Unkown Starting Method and is currently used by Subseven.</p>
<p>9. Icq Inet</p>
<p>[HKEY_CURRENT_USER\Software\Mirabilis\ICQ\Agent\Apps\test]</p>
<p>"Path"="test.exe"</p>
<p>"Startup"="c:\\test"</p>
<p>"Parameters"=""</p>
<p>"Enable"="Yes"</p>
<p>[HKEY_CURRENT_USER\Software\Mirabilis\ICQ\Agent\Apps\</p>
<p>This key includes all the APPS which are executed IF ICQNET Detects an Internet Connection.</p>
<p>10. Explorer start-up</p>
<p>Windows 95,98,ME</p>
<p>Explorer.exe ist started through a system.ini entry, the entry itself contains no path information so if c:\explorer.exe exist it will be started instead of c:\$winpath\explorer.exe.</p>
<p>Windows NT/2000</p>
<p>The Windows Shell is the familiar desktop that's used for interacting with Windows. During system startup, Windows NT 4.0 and Windows 2000 consult the "Shell" registry entry, HKEY_LOCAL_MACHINE\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon\Shell, to determine the name of the executable that should be loaded as the Shell.</p>
<p>By default, this value specifies Explorer.exe.</p>
<p>The problem has to do with the search order that occurs when system startup is in process. Whenever a registry entry specifies the name of a code module, but does it using a relative path, Windows initiates a search process to find the code. The search order is as follows:</p>
<p>Search the current directory.</p>
<p>If the code isn't found, search the directories specified in HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment\Path, in the order in which they are specified.</p>
<p>If the code isn't found, search the directories specified in HKEY_CURRENT_USER\Environment\Path, in the order in which they are specified.</p>
<p>More info : [URL=http://www.microsoft.com/technet/security/bulletin/fq00-052.asp]http://www.microsoft.com/technet/security/bulletin/fq00-052.asp[/URL]</p>
<p>Patch : [URL=http://www.microsoft.com/technet/support/kb.asp?ID=269049]http://www.microsoft.com/technet/support/kb.asp?ID=269049[/URL]</p>
<p>General :</p>
<p>If a trojan installs itself as c:\explorer no run keys or other start-up entries are needed. If c:\explorer.exe is a corrupted file the user will be locked out of the system. Affects all windows version as of today.</p>
<p>10. Active-X Component</p>
<p> HKEY_LOCAL_MACHINE\Software\Microsoft\Active Setup\Installed Components\KeyName</p>
<p>StubPath=C:\PathToFile\Filename.exe</p>
<p>Believe it or not, this does start filename.exe BEFORE the shell and any other Program normaly started over the Run Keys.</p>
<p>Misc Information</p>
<p>[HKEY_LOCAL_MACHINE\Software\CLASSES\ShellScrap] @="Scrap object"</p>
<p>"NeverShowExt"=""</p>
<p>The NeverShowExt key has the function to HIDE the real extension of the file (here) SHS. This means if you rename a file as "Girl.jpg.shs" it displays as "Girl.jpg" in all programs including Explorer.</p>
<p>Your registry should be full of NeverShowExt keys, simply delete the key to get the real extension to show up.</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
