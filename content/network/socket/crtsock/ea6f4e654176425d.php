<h1>PopSock.pas</h1>
<div class="date">01.01.2007</div>


<pre>
unit PopSock;
 
{
  CrtSocket for Delphi 32
  Copyright (C) 1999-2001  Paul Toth &lt;tothpaul@free.fr&gt;
  http://tothpaul.free.fr
 
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
 
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 
}
 
interface
 
uses
 CrtSock,SysUtils;
 
Function OpenMailBox(Server,User,Password:string):integer;
Procedure CloseMailBox;
Function MailCount:integer;
Function GetMail(Index:integer):string;
 
Function MailError:string;
 
implementation
 
var
 popin,popout:TextFile;
 last:string;
 read:boolean;
 
Function MailError:string;
 begin
  result:=last;
 end;
 
Function ReadString:string;
 begin
  repeat
   readln(popin,Result);
  until (Length(Result)&lt;4)or(Result[4]&lt;&gt;'-');
  last:=Result;
 end;
 
Procedure WriteString(s:string);
 begin
  WriteLn(popout,s);
 end;
 
Function Status:char;
 var
  s:string;
 begin
  s:=ReadString;
  if s='' then Status:='?' else Status:=s[1];
 end;
 
Function Exec(cmd:string):char;
 begin
  Writestring(cmd);
  Result:=Status;
 end;
 
Function OpenMailBox(Server,User,Password:string):integer;
 begin
  Result:=CallServer(Server,110);
  if Result&gt;0 then begin
   AssignCrtSock(Result,popin,popout);
   if Status='+' then begin
    if (Exec('USER '+User)='+') and (Exec('PASS '+Password)='+') then exit;
    Disconnect(Result);
    Result:=-3;
   end else begin
    Disconnect(Result);
    Result:=-2;
   end;
  end;
 end;
 
Procedure CloseMailBox;
 begin
  Exec('QUIT');
  CloseFile(popout);
 end;
 
Function MailCount:integer;
 var
  i:integer;
 begin
  Result:=-1;
  if Exec('STAT')&lt;&gt;'+' then exit;
  i:=pos(' ',Last); if i=0 then exit;
  while Last[i]=' ' do inc(i);
  Result:=0;
  while (i&lt;length(Last))and(Last[i] in ['0'..'9']) do begin
   Result:=10*Result+ord(Last[i])-ord('0');
   inc(i);
  end;
 end;
 
Function GetMail(Index:integer):string;
 var
  s:string;
 begin
  Writeln(popout,'RETR ',Index);
  result:='';
  if Status='+' then begin
   ReadLn(popin,s);
   while s&lt;&gt;'' do begin
    result:=result+s+#13#10; // header
    ReadLn(popin,s);
   end;
   Repeat
    result:=result+s+#13#10; // body
    ReadLn(popin,s);
   until s='.';
  end;
 end;
 
end.
</pre>

