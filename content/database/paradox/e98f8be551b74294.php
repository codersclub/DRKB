<h1>Reading the autoincrement value of Paradox table</h1>
<div class="date">01.01.2007</div>


<p>The current highest value is stored beginning at byte 73 decimal. </p>
<p>The next value is determined by adding 1 to it.</p>
<p>Here is a simple Delphi function that returns the current</p>
<p>autoincrement value.</p>
<pre>function getAutoInc(filename: string): LongInt;
var
  mystream: tfilestream;
  buffer: longint;
begin
  mystream := tfilestream.create(filename,
    fmOpenread + fmShareDenyNone);
  mystream.Seek(73, soFromBeginning);
  mystream.readbuffer(buffer, 4);
  mystream.Free;
  getAutoInc := buffer;
end;
</pre>

