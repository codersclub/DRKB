<h1>Установка Kylix под новые версии Linux (ядро 2.6)</h1>
<div class="date">01.01.2007</div>


<p>Взято с <a href="https://www.nux.co.za/" target="_blank">https://www.nux.co.za/</a></p>
<p>Follow these steps to fix/patch kylix 3 work:</p>
<p>Step 1</p>
<p>Download the ilink and ilink.so patch provided by Andreas Hausladen here:</p>
<p><a href="https://unvclx.sourceforge.net/downloads/ilinkPatch.tar.gz" target="_blank">ilinkpatch</a> for more info on the patch go to <a href="https://unvclx.sourceforge.net/" target="_blank">unvclx.sourceforge.net</a></p>
<p>To install just go to the download directory and run</p>
<p>./ilinkPatch /home/yourname/kylix</p>
<p>Step 2 </p>
<p>Download the latest 3.6 clx patch provided by Andreas Hausladen from <a href="https://unvclx.sourceforge.net/" target="_blank">unvclx.sourceforge.net</a> or <a href="https://nux.co.za/media/k3patches.20040915.tar.bz2" target="_blank">here</a>. Copy or save this file to /tmp folder </p>
<p>Install the patch by executing the following from the shell</p>
<p>tar -jxf k3patches.20040915.tar.bz2</p>
<p>/tmp/k3patches/installpatch</p>
<p>Step 3</p>
<p>Download and install the older compatible glibc libraries for running kylix apps from <a href="https://nux.co.za/media/compat-glibc-6.2-2.1.3.2.i386.rpm" target="_blank">here</a>. Save or copy it to /tmp.</p>
<p>Install by runing from the shell</p>
<p>rpm -i /tmp/compat-glibc-6.2-2.1.3.2.i386.rpm</p>
<p>Now the patching is complete.... now to run kylix do the following</p>
<p>Step 4</p>
<p>export LD_ASSUME_KERNEL=2.4.21</p>
<p>Step 5</p>
<p>Run/Start kylix via </p>
<p>/usr/local/kylix3/bin/startbcb</p>
<p>Step 6</p>
<p>Open your project and change your projects include directories via the project options by adding</p>
<p>/usr/i386-glibc21-linux/include </p>
<p>/usr/include</p>
<p>as the very first include paths to that your include paths.. </p>
<p>this will fix the error so that the correct "time.h" be included.</p>
<p>Step 7</p>
<p>Change your lib paths by adding (preferably in the beginning)</p>
<p>/usr/i386-glibc21-linux/lib and</p>
<p>/usr/lib</p>
<p>Finally: </p>
<p>Open the ThrdDemo (the c++ demo included with Kylix in the examples directory) This sample demonstrates the use of threads and different sort algorithms... (remember step 6+7 for this project).</p>
<p>Compile and run/debug....</p>
<p>Congatulations!!! your have done it!!!</p>

