---
Title: Способы уменьшения размера exe-файлов, полученных с помощью Delphi
Date: 01.01.2007
---


Способы уменьшения размера exe-файлов, полученных с помощью Delphi
==================================================================

::: {.date}
01.01.2007
:::

Generally, EXE files created with Delphi are larger than EXE files
created with another programming language. The reason is the VCL. (Sure,
VCL has many advantages\...)

There are several ways to reduce a EXE\'s size:

01\) Use a EXE-Packer (UPX, ASPack,\...)

02\) Use KOL.

03\) Write your application without VCL

04\) Use the ACL (API Controls Library)

05\) Use StripReloc.

06\) Deactivate remote debugging information and TD32.

07\) You might want to put code in a dll.

08\) Don\'t put the same images several times on a form. Load them at
runtime.

09\) Use compressed images (JPG and not BMP)

10\) Store less properties in DFM files

(See Link below \"How To Make Your EXE\'s Lighter\")

11\) Use the TStringList replacement by \~LOM\~

12\) Use the Minireg - TRegistry replacement by Ben Hochstrasser



01)

UPX is a free, portable, extendable, high-performance executable
packer for several different executable formats. It achieves an
excellent compression ratio and offers very fast decompression.

Your executables suffer no memory overhead or other drawbacks.

<https://upx.sourceforge.net/>

ASPack is an advanced Win32 executable file compressor, capable of
reducing the file size of

32-bit Windows programs by as much as 70%. (ASPack\'s compression ratio
improves upon the

industry-standard zip file format by as much as 10-20%.) ASPack makes
Windows 95/98/NT

programs and libraries smaller, and decrease load times across networks,
and download

times from the internet; it also protects programs against reverse
engineering

by non-professional hackers.

Programs compressed with ASPack are self-contained and run exactly as
before,

with no runtime performance penalties.

<https://www.aspack.com/aspack.htm>

{\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*}

02)

KOL - Key Objects Library is a set of objects to develop power

(but small) 32 bit Windows GUI applications using Delphi but without
VCL.

It is distributed free of charge, with source code.

<https://bonanzas.rinet.ru/>

{\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*}

03)

nonVCL

Delphi lets you have it both ways. If you want tiny EXE\'s, then don\'t use
the VCL. Its entirely possible to use all the rich features of Delphi IDE
using 100% WinAPI calls, standard resources, etc.

<https://nonvcl.luckie-online.de>

<https://www.erm.tu-cottbus.de/delphi/stuff/Tutorials/nonVCL/index.html>

<https://www.angelfire.com/hi5/delphizeus/>

<https://www.tutorials.delphi-source.de/nonvcl/>

{\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*}

04)

ACL (API Controls Library)

To write the program on pure API certainly it is possible, but I have
deci-

ded to reach both goals - both to make that program and to receive the
tool,

through which it would be possible in further to build similar programs,
almost,

as on Delphi with VCL. So the idea to create my own TWinControl and all
standard

Windows controls classes, derived from it has appeared.

<https://www.apress.ru/pages/bokovikov/delphi/index.html/>

{\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*}

05)

StripReloc is a free (GPL license) command line utility that removes the
relocation

(\".reloc\") section from Win32 PE EXE files, reducing their size.

Most compilers/linkers (including Delphi) put a relocation section in
EXE files,

but this is actually not necessary since EXEs never get relocated.

Hence, a relocation section only wastes space.

Why not use an EXE compressor?

<https://www.jrsoftware.org/striprlc.php>

{\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*}

06)

Deactivating the Debug Information

Exclude any debug information for the final build

(project-Options Compiler - Debugging and project-Options

Linker EXE and DLL options)

Dependeing on the amount of Debug information,

Debugging can take up until half of the size.

The options that are going to singificantly reduce your file size are

\"Include TD32 debug info\" and \"Build with runtime packages\". If you
are

shipping commercial applications, you usually don\'t need the debug info

linked with your project.

{\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*}

08/09)

About Images

The forms in your project have any bitmaps on them, then these are

compiled into the EXE. If you use the same bitmap multiple times, don\'t

assign them at design-time in the IDE as it will be included in the EXE

multiple times, assign them in code instead.

This can help reduce the size of the EXE, especially if you use large

bitmaps.

Use JPEG-files instead of BMP-files. This also reduces the EXE size.

{\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*}

10)

How To Make Your EXE\'s Lighter:

<https://www.undu.com/DN970301/00000064.htm>

{\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*\*}

11)

[TStringList replacement by \~LOM\~](https://www.virustrading.com/positron/delphi/tstrlist.rar)

12)

[Minireg - TRegistry replacement](https://www.virustrading.com/positron/delphi/minireg.zip)

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
