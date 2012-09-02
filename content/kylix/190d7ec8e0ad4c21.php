<h1>Как сделать mount?</h1>
<div class="date">01.01.2007</div>


<pre>
{  The following example shows a Linux-Console application, which mount 
  the floppy. 
} 
 
program Project1; 
 
{$APPTYPE CONSOLE} 
uses 
  Libc; 
 
begin 
  if mount('/dev/fd0', '/mnt/floppy', 'vfat', MS_RDONLY, nil) = -1 then 
    WriteLn('Mount return : ', Errno, '(', strerror(errno), ')') 
  else 
    WriteLn('Floppy mounted'); 
end. 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
