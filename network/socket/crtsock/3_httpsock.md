---
Title: HttpSock.pas
Date: 01.01.2007
---


HttpSock.pas
============

    unit HttpSock;
     
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
     
    function URLEncode(s:string):string;
    function URLDecode(s:string):string;
     
    function HttpGet(server,url:string; var header:string):string;
    function HttpPost(server,url,data:string; var header:string):string;
     
    implementation
     
    uses
     crtsock,sysutils;
     
    function URLEncode(s:string):string; // http://www.cis.ohio-state.edu/cgi-bin/rfc/rfc1738.html
     var
      i:integer;
      c:char;
     begin
      result:='';
      for i:=1 to length(s) do begin
       c:=s[i];
       case c of
       // non-ASCII
        #$00..#$1F,#$7F,#$80..#$FF,
       // unsafe
        {' ',}'<','>','"','#','%','}','|','\','^','~', '[', ']', '`',
       // reserved
        ';','/','?',':','@','=','&',
        '$','-','_','.','+','!','*','''','(',')':
         result:=result+'%'+IntToHex(ord(c),2);
        ' ' :result:=result+'+'; 
        else result:=result+c;
       end;
      end;
     end;
     
    function URLDecode(s:string):string;
     var
      i:integer;
     begin
      result:='';
      i:=1;
      while i<=length(s) do begin
       case s[i] of
        '+':result:=result+' ';
        '%':begin
             s[i]:='$';
             result:=result+chr(StrToInt(copy(s,i,3)));
             inc(i,2);
            end;
        else result:=result+s[i];
       end;
       inc(i);
      end;
     end;
     
     
    function HttpGet(server,url:string; var header:string):string;
     var
      handle:integer;
      sin,sout:textfile;
      s:string;
     begin
      handle:=callserver(server,80);
      if handle<=0 then begin
       result:='';
       exit;
      end;
      assigncrtsock(handle,sin,sout);
      writeln(sout,'GET ',url,' HTTP/1.0');
      writeln(sout,'Accept: */*');
      writeln(sout,'Accept-Language: fr');
      writeln(sout,'User-Agent: Mozilla/4.0 (compatible; MSIE 5.5; Windows 98; FREE)');
    //  writeln(sout,'User-Agent: MySoft/1.0 (Delphi)');
      writeln(sout,'Connection: Keep-Alive');
      if header<>'' then writeln(sout,header);
      writeln(sout);
     
      header:='';
      result:='';
     
      readln(sin,s);
      while s<>'' do begin
       header:=header+s;
       readln(sin,s);
      end;
     
      while not eof(sin) do begin
       readln(sin,s);
       result:=result+s;
      end;
     
      disconnect(handle);
     end;
     
    function HttpPost(server,url,data:string; var header:string):string;
     var
      handle:integer;
      sin,sout:textfile;
      s:string;
     begin
      handle:=callserver(server,80);
      if handle<=0 then begin
       result:='';
       exit;
      end;
      assigncrtsock(handle,sin,sout);
      writeln(sout,'POST ',url,' HTTP/1.0');
      writeln(sout,'Accept: */*');
      writeln(sout,'Accept-Language: fr');
      writeln(sout,'User-Agent: Mozilla/4.0 (compatible; MSIE 5.5; Windows 98; FREE)');
    //  writeln(sout,'User-Agent: MySoft/1.0 (Delphi)');
      writeln(sout,'Content-length: ',Length(data));
      writeln(sout,'Connection: Keep-Alive');
      if header<>'' then writeln(sout,header);
      writeln(sout);
      write(sout,data);
     
      header:='';
      result:='';
     
      readln(sin,s);
      while s<>'' do begin
       header:=header+s;
       readln(sin,s);
      end;
     
      while not eof(sin) do begin
       readln(sin,s);
       result:=result+s;
      end;
     
      disconnect(handle);
     end;
     
    end.
