<h1>Способы уменьшения размера exe-файлов, полученных с помощью Delphi</h1>
<div class="date">01.01.2007</div>


<p>Generally, EXE files created with Delphi are larger than EXE files created with another programming language. The reason is the VCL. (Sure, VCL has many advantages...)</p>

<p>There are several ways to reduce a EXE's size:</p>

<p>01) Use a EXE-Packer (UPX, ASPack,...)</p>
<p>02) Use KOL.</p>
<p>03) Write your application without VCL</p>
<p>04) Use the ACL (API Controls Library)</p>
<p>05) Use StripReloc.</p>
<p>06) Deactivate remote debugging information and TD32.</p>
<p>07) You might want to put code in a dll.</p>
<p>08) Don't put the same images several times on a form. Load them at runtime.</p>
<p>09) Use compressed images (JPG and not BMP)</p>
<p>10) Store less properties in DFM files</p>
<p>(See Link below "How To Make Your EXE's Lighter")</p>

<p>11) Use the TStringList replacement by ~LOM~</p>
<p>Use the Minireg - TRegistry replacement by Ben Hochstrasser</p>

<p>01)</p>
<p>UPX is a free, portable, extendable, high-performance executable</p>
<p>packer for several different executable formats. It achieves an excellent</p>
<p>compression ratio and offers very fast decompression.</p>
<p>Your executables suffer no memory overhead or other drawbacks.</p>

<a href="https://upx.sourceforge.net/" target="_blank">https://upx.sourceforge.net/</a></p>

<p>ASPack is an advanced Win32 executable file compressor, capable of reducing the file size of</p>
<p>32-bit Windows programs by as much as 70%. (ASPack's compression ratio improves upon the</p>
<p>industry-standard zip file format by as much as 10-20%.) ASPack makes Windows 95/98/NT</p>
<p>programs and libraries smaller, and decrease load times across networks, and download</p>
<p>times from the internet; it also protects programs against reverse engineering</p>
<p>by non-professional hackers.</p>
<p>Programs compressed with ASPack are self-contained and run exactly as before,</p>
<p>with no runtime performance penalties.</p>

<a href="https://www.aspack.com/aspack.htm" target="_blank">https://www.aspack.com/aspack.htm</a></p>

<p>{****************************************************************}</p>

<p>02)</p>
<p>KOL - Key Objects Library is a set of objects to develop power</p>
<p>(but small) 32 bit Windows GUI applications using Delphi but without VCL.</p>
<p>It is distributed free of charge, with source code.</p>

<a href="https://bonanzas.rinet.ru/" target="_blank">https://bonanzas.rinet.ru/</a></p>

<p>{****************************************************************}</p>

<p>03)</p>
<p>nonVCL</p>
<p>Delphi lets you have it both ways. If you want tiny EXE's, then don't use</p>
<p>the VCL. Its entirely possible to use all the rich features of Delphi IDE</p>
<p>using 100% WinAPI calls, standard resources, etc.</p>

<a href="https://nonvcl.luckie-online.de" target="_blank">https://nonvcl.luckie-online.de</a></p>
<a href="https://www.erm.tu-cottbus.de/delphi/stuff/Tutorials/nonVCL/index.html" target="_blank">https://www.erm.tu-cottbus.de/delphi/stuff/Tutorials/nonVCL/index.html</a></p>
<a href="https://www.angelfire.com/hi5/delphizeus/" target="_blank">https://www.angelfire.com/hi5/delphizeus/</a></p>
<a href="https://www.tutorials.delphi-source.de/nonvcl/" target="_blank">https://www.tutorials.delphi-source.de/nonvcl/</a></p>

<p>{****************************************************************}</p>

<p>04)</p>

<p>ACL (API Controls Library)</p>
<p>To write the program on pure API certainly it is possible, but I have deci-</p>
<p>ded to reach both goals - both to make that program and to receive the tool,</p>
<p>through which it would be possible in further to build similar programs, almost,</p>
<p>as on Delphi with VCL. So the idea to create my own TWinControl and all standard</p>
<p>Windows controls classes, derived from it has appeared.</p>

<a href="https://www.apress.ru/pages/bokovikov/delphi/index.html/" target="_blank">https://www.apress.ru/pages/bokovikov/delphi/index.html/</a></p>

<p>{****************************************************************}</p>

<p>05)</p>
<p>StripReloc is a free (GPL license) command line utility that removes the relocation</p>
<p>(".reloc") section from Win32 PE EXE files, reducing their size.</p>
<p>Most compilers/linkers (including Delphi) put a relocation section in EXE files,</p>
<p>but this is actually not necessary since EXEs never get relocated.</p>
<p>Hence, a relocation section only wastes space.</p>

<p>Why not use an EXE compressor?</p>
<a href="https://www.jrsoftware.org/striprlc.php" target="_blank">https://www.jrsoftware.org/striprlc.php</a></p>

<p>{****************************************************************}</p>

<p>06)</p>
<p>Deactivating the Debug Information </p>

<p>Exclude any debug information for the final build</p>
<p>(project-Options Compiler - Debugging and project-Options</p>
<p>Linker EXE and DLL options)</p>
<p>Dependeing on the amount of Debug information,</p>
<p>Debugging can take up until half of the size.</p>

<p>The options that are going to singificantly reduce your file size are</p>
<p>"Include TD32 debug info" and "Build with runtime packages". If you are</p>
<p>shipping commercial applications, you usually don't need the debug info</p>
<p>linked with your project.</p>

<p>{****************************************************************}</p>

<p>08/09)</p>
<p>About Images</p>

<p>The forms in your project have any bitmaps on them, then these are</p>
<p>compiled into the EXE. If you use the same bitmap multiple times, don't</p>
<p>assign them at design-time in the IDE as it will be included in the EXE</p>
<p>multiple times, assign them in code instead.</p>
<p>This can help reduce the size of the EXE, especially if you use large</p>
<p>bitmaps.</p>

<p>Use JPEG-files instead of BMP-files. This also reduces the EXE size.</p>

<p>{****************************************************************}</p>

<p>10)</p>
<p>How To Make Your EXE's Lighter:</p>
<a href="https://www.undu.com/DN970301/00000064.htm" target="_blank">https://www.undu.com/DN970301/00000064.htm</a></p>

<p>{****************************************************************}</p>

<p>11)</p>
<a href="https://www.virustrading.com/positron/delphi/tstrlist.rar" target="_blank">TStringList replacement by ~LOM~</a></p>
<a href="https://www.virustrading.com/positron/delphi/minireg.zip" target="_blank">Minireg - TRegistry replacement </a></p>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
