---
Title: SmtpSock.pas
Date: 01.01.2007
---


SmtpSock.pas
============

    unit SmtpSock;
     
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
     
    Uses
     CrtSock,Classes;
     
    Function SmtpOpen(Server:string):integer;
    Function SmtpError:string;
    Procedure SmtpClose;
    Function SmtpFrom(Email:string):boolean;
    Function SmtpTo(Email:string):boolean;
     
    Function SmtpHead(From,Rcpt,Subject:string):boolean;
    Function SmtpSend(From,Rcpt,Subject:string; Msg:TStrings):boolean;
    procedure SmtpJoin(Name:string; Stream:TStream; Count:integer);
    Function SmtpDone:boolean;
     
    implementation
     
    var
     sin,sout:TextFile;
     last:string;
     
    Function ReadString:string;
     begin
      repeat
       readln(sin,Result);
    //   writeln(result);
      until (Length(Result)<4)or(Result[4]<>'-');
      last:=Result;
     end;
     
    Procedure WriteString(s:string);
     begin
    //  writeln('>>>',s);
      WriteLn(sout,s);
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
     
    Function SmtpOpen(Server:string):integer;
     begin
      Last:='Server not found';
      Result:=CallServer(Server,25);
      if Result>0 then begin
       AssignCrtSock(Result,sin,sout);
       if Status='2' then begin
        if Exec('HELO MySoft.Delphi')='2' then exit;
        Disconnect(Result);
        Result:=-3;
       end else begin
        Disconnect(Result);
        Result:=-2;
       end;
      end;
     end;
     
    Function SmtpError:string;
     begin
      Result:=Last;
     end;
     
    Procedure SmtpClose;
     begin
      CloseFile(sout);
     end;
     
    Function SmtpFrom(Email:string):boolean;
     begin
      Result:=(Exec('MAIL '+'From: '+EMail)='2');
     end;
     
    Function SmtpTo(EMail:string):boolean;
     begin
      Result:=(Exec('RCPT To:'+Email)='2');
     end;
     
    Function SmtpHead(From,Rcpt,Subject:string):boolean;
     begin
      Result:=False;
      if Exec('DATA')<>'3' then exit;
      WriteString('From: '+From);
      WriteString('To: '+Rcpt);
      WriteString('Subject: '+Subject);
      WriteString('Content-Type: text/plain; charset=ISO-8859-1');
      WriteString('Content-Transfer-Encoding: 8bit'#13#10);
      WriteString('');
      Result:=True;
     end;
     
    Function SmtpSend(From,Rcpt,Subject:string; Msg:TStrings):boolean;
     begin
      Result:=False;
      if not SmtpHead(From,Rcpt,Subject) then exit;
      WriteString(Msg.Text);
      Result:=SmtpDone;
     end;
     
    function uchr(b:byte):char;
     begin
      if b=0 then result:=#96 else result:=chr(b+32);
     end;
     
    procedure SmtpJoin(Name:string; Stream:TStream; Count:integer);
     var
      s:string[76];
      size:integer;
      u:string;
      ss:integer;
      c1,c2:byte;
      x:integer;
     begin
      WriteString('begin 600 '+Name);
      size:=45;
      while Count>0 do begin
       if size>Count then size:=count;
       dec(count,size);
       Stream.Read(s[1],size);
       u:=uchr(size);
       ss:=2;
       c2:=0;
       for x:=1 to size do begin
        c1:=ord(s[x]);
        u:=u+uchr(c2 or (c1 shr ss));
        c2:=(c1 shl (6-ss)) and 63;
        ss:=(ss+2) and 7;
        if ss=0 then begin
         ss:=2;
         u:=u+uchr(c2);
         c2:=0;
        end;
       end;
       if (ss>2) then begin
        u:=u+uchr(c2)+#96;
        if ss=4 then u:=u+#96;
       end;
       WriteString(u);
      end;
      writeString('end');
     end;
     
    Function SmtpDone:boolean;
     begin
      Result:=(Exec('.')='2');
      CloseFile(sout);
     end;
     
    end.
