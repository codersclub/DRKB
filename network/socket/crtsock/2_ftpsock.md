---
Title: FtpSock.pas
Date: 01.01.2007
---


FtpSock.pas
===========

    unit FtpSock;
     
    {
      CrtSocket for Delphi 32
      Copyright (C) 1999-2001  Paul Toth <tothpaul@free.fr>
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
     
    Function FtpLogon(Server,User,Password:string):integer;
    Procedure FtpLogoff;
    Function FtpQuote(cmd:string):boolean;
    Function FtpOpenWrite(FileName:string):integer;
    Function FtpOpenRead(FileName:string):integer;
    Function FtpClose(FileHandle:integer):boolean;
     
    Function FtpError:string;
     
    implementation
     
    var
     ftpin,ftpout:TextFile;
     last:string;
     read:boolean;
     
    Function FtpError:string;
     begin
      result:=last;
     end;
     
    Function ReadString:string;
     begin
      repeat
       readln(ftpin,Result);
    //   writeln(result);
      until (Length(Result)<4)or(Result[4]<>'-');
      last:=Result;
     end;
     
    Procedure WriteString(s:string);
     begin
    //  writeln('>>>',s);
      WriteLn(ftpout,s);
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
     
    Function FtpLogon(Server,User,Password:string):integer;
     begin
      Result:=CallServer(Server,21);
      if Result>0 then begin
       AssignCrtSock(Result,ftpin,ftpout);
       if Status='2' then begin
        if (Exec('USER '+User)='3') and (Exec('PASS '+Password)='2') then exit;
        Disconnect(Result);
        Result:=-3;
       end else begin
        Disconnect(Result);
        Result:=-2;
       end;
      end;
     end;
     
    Procedure FtpLogoff;
     begin
      Exec('QUIT');
      CloseFile(ftpout);
     end;
     
    Function FtpQuote(cmd:string):boolean;
     begin
      Writestring(Cmd);
      Result:=(Status='2');
     end;
     
    Function GetValue(var s:string):integer;
     var
      i:integer;
     begin
      i:=length(s); while s[i]<>',' do dec(i);
      Result:=StrToInt(copy(s,i+1,3));
      SetLength(s,i-1);
     end;
     
    Function FtpOpenWrite(FileName:string):integer;
     var
      s:string;
      b,e:integer;
      port:word;
     begin
      read:=false;
      Result:=-1;
      if Exec('PASV')<>'2' then exit;
      b:=4; while (b<length(last)) and (not (last[b] in ['0'..'9'])) do inc(b);
      e:=Length(last); while (e>0) and (not (last[b] in ['0'..'9'])) do dec(b);
      s:=copy(last,b,e-b-1);
      port:=getvalue(s);
      port:=256*getvalue(s)+port;
      for e:=1 to Length(s) do if s[e]=',' then s[e]:='.'; // replace "," by "." in IP address
      WriteString('STOR '+FileName);
    //  writeln('call ',s,':',port);
      Result:=CallServer(s,port);
      if (Status<>'1')and(Result>=0) then begin
       Disconnect(Result);
       Result:=-1;
      end;
     end;
     
    Function FtpOpenRead(FileName:string):integer;
     var
      s:string;
      b,e:integer;
      port:word;
     begin
      read:=true;
      Result:=-1;
      if Exec('PASV')<>'2' then exit;
      b:=4; while (b<length(last)) and (not (last[b] in ['0'..'9'])) do inc(b);
      e:=Length(last); while (e>0) and (not (last[b] in ['0'..'9'])) do dec(b);
      s:=copy(last,b,e-b-1);
      port:=getvalue(s);
      port:=256*getvalue(s)+port;
      for e:=1 to Length(s) do if s[e]=',' then s[e]:='.'; // replace "," by "." in IP address
      WriteString('RETR '+FileName);
      Result:=CallServer(s,port);
      if (Status<>'1')and(Result>=0) then begin
       Disconnect(Result);
       Result:=-1;
      end;
     end;
     
    Function FtpClose(FileHandle:integer):boolean;
     begin
      Disconnect(FileHandle);
      result:=Status='2';
     end;
     
    end.
