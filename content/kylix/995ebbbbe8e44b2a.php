<h1>How do I create an executible file using the command line directive in Linux with Kylix?</h1>
<div class="date">01.01.2007</div>


<p>How do I create an executable file, i.e. foo.exe, using dcc in Kylix? </p>
<p>Create the project file, i.e. foo.dpr, using VI, Pico or some other text writing tool. Next, at the command line type: dcc foo. You can pass in flags like -BE: dcc -BE foo, the will build and execute the file. There are a number of different flags you can pass in, look at the help for dcc for a full listing and description. </p>
<pre>
program foo
 
uses
  SysUtils;
 
begin
  writeln('Hello World');
  readln;
end.
</pre>

