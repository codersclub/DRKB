---
Title: Converting 16bit resource to 32bit
Date: 01.01.2007
---

Converting 16bit resource to 32bit
==================================

If you have the original source file (.rc) then you can simply recompile
the .rc file to a .res file using the Borland Resource Command Line
Compiler (brcc32.exe) located in the Delphi/C++ Builders bin directory.
If you only have a .res file to work with, you will need to use a
quality resource compiler/decompiler such as Borland\'s Resource
Workshop. Versions of the Borland\'s Resource Workshop later than 4.5
can extract, compile, and decompile both 16 and 32 bit resource files
from a variety of sources including .res, .exe, .dll, drv, and .cpl
files. The Borland Resource Workshop version 4.5 ship with the Borland
RAD Pack product line
