<h1>Как найти пароль к базе данных?</h1>
<div class="date">01.01.2007</div>



<p>I know there that there are many utilities out there costing $$ for removing the password of an access database. Here's how to implement it in Delphi.Please note that this method is not meant for a database with user-level security and work group information file. The idea is based on the file format of an access db. </p>

<p>The password is stored from location $42 and encrypted using simple xoring. The following function does decryption. </p>
<pre>
function GetPassword(filename: string): string;
var
  Stream: TFilestream;
  buffer: array[0..12] of char;
  str: string;
begin
  try
    stream := TFileStream.Create(filename, fmOpenRead);
  except
    ShowMessage('Could not open the file.Make sure that the file is not in use.');
    exit;
  end;
  stream.Seek($42, soFromBeginning);
  stream.Read(buffer, 13);
  stream.Destroy;
 
  str := chr(Ord(buffer[0]) xor $86);
  str := str + chr(Ord(buffer[1]) xor $FB);
  str := str + chr(Ord(buffer[2]) xor $EC);
  str := str + chr(Ord(buffer[3]) xor $37);
  str := str + chr(Ord(buffer[4]) xor $5D);
  str := str + chr(Ord(buffer[5]) xor $44);
  str := str + chr(Ord(buffer[6]) xor $9C);
  str := str + chr(Ord(buffer[7]) xor $FA);
  str := str + chr(Ord(buffer[8]) xor $C6);
  str := str + chr(Ord(buffer[9]) xor $5E);
  str := str + chr(Ord(buffer[10]) xor $28);
  str := str + chr(Ord(buffer[11]) xor $E6);
  str := str + chr(Ord(buffer[12]) xor $13);
  Result := str;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
