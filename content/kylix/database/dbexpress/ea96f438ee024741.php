<h1>Accessing InterBase via dbExpress with Kylix produces error: «Unable to load libgds.so»</h1>
<div class="date">01.01.2007</div>


<p>If you install the dbExpress InterBase client driver, you will need to have libcrypt.so installed. Some Linux distributions omit this library or do not include it in a base install. If your distribution does not include libcrypt.so, contact the package maintainer, or search online Linux resources, such as {http://rpmfind.net/}.</p>
<p>Some Linux distributions provide all the libraries required to run Kylix, but do not use the naming conventions that Kylix expects. The most common problem is library names with embedded version information, while Kylix expects version-independent names. If Kylix software fails to run because of missing shared libraries, check for similarly named libraries in /lib and /usr/lib. You can then create a symbolic link to help Kylix find the library. For example, if you are missing libcrypt.so but find /lib/libcrypt.so.1, you would enter the following shell commands as root:</p>
<p>cd /lib</p>
<p>ln -s libcrypt.so.1 libcrypt.so</p>
