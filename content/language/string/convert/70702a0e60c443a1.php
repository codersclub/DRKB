<h1>PChar &gt; Integer</h1>
<div class="date">01.01.2007</div>


<p>Many Windows functions claim to want PChar parameters in the documentation, but they are defined as requiring LongInts.</p>
<p>Is this a bug?</p>
<p>No, this is where "typecasting" is used. Typecasting allows you to fool the compiler into thinking that one type of variable is of another type for the ultimate in flexibility. The last parameter of  the Windows API function SendMessage() is a good example. It is</p>
<p>documented as requiring a long integer, but commonly requires a PChar for some messages (WM_WININICHANGE). Generally, the variable you are typecasting from must be the same size as the variable type you are casting it to. In the SendMessage example, you could typecast a PChar as a longint, since both occupy 4 bytes of memory:</p>
<pre>var 
   s : array[0..64] of char; 
begin 
  StrCopy(S, 'windows'); 
  SendMessage(HWND_BROADCAST, WM_WININICHANGE, 0, LongInt(@S)); 
end; 
</pre>

