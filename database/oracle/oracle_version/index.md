---
Title: Как выяснить номер версии Oracle?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как выяснить номер версии Oracle?
=================================

This function gets the connected Oracle version. It returns the version
info in 3 OUT parameters.

    VerNum      : double        eg. 7.23
    VerStrShort : string        eg. '7.2.3.0.0'
    VerStrLong  : string        eg. 'Oracle7 Server Release 7.2.3.0.0 - Production Release'

I have tested it with Oracle 7.2 and 8.17. I assume it should work for
the others (not too sure about Oracle 9 though). Any feedback and fixes
for different versions would be appreciated.

The TQuery parameter that it recieves is a TQuery component that is
connected to an open database connection.

Example :

    var
      VNum: double;
      VShort: string;
      VLong: string;
    begin
      GetOraVersion(MySql, VNum, VShort, VLong);
      Label1.Caption := FloatToStr(VNum);
      Label2.Caption := VShort;
      Label3.Caption := VLong;
    end;
     
    procedure GetOraVersion(Query: TQuery;
                            out VerNum: double;
                            out VerStrShort: string;
                            out VerStrLong: string);
    var
      sTmp: string;
      cKey: char;
      i: integer;
    begin
      Query.SQL.Text := 'select banner from v$version ' +
                        'where banner like ' + QuotedStr('Oracle%');
      Query.Open;
     
      if not Query.Eof then
        VerStrLong := Query.Fields[0].AsString
      else
      begin
        // Don't know this version
        VerStrLong := '?';
        VerNum := 0.0;
        VerStrShort := '?.?.?.?';
      end;
     
      Query.Close;
     
      if VerStrLong <> '?' then
      begin
        cKey := VerStrLong[7]; // eg. Oracle7 or Oracle8i
        VerStrLong[7] := 'X'; // Mask it out
        sTmp := copy(VerStrLong, pos(cKey, VerStrLong), 1024);
        VerStrShort := copy(sTmp, 1, pos(' ', sTmp) - 1);
        sTmp := copy(VerStrShort, 1, pos('.', VerStrShort));
     
        for i := length(sTmp) + 1 to length(VerStrShort) do
        begin
          if VerStrShort[i] <> '.' then
            sTmp := sTmp + VerStrShort[i];
        end;
     
        VerNum := StrToFloat(sTmp);
        VerStrLong[7] := cKey; // Put correct character back
      end;
    end;

