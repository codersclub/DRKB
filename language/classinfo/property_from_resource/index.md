---
Title: Как прочитать свойство напрямую из его ресурса?
Date: 01.01.2007
Author: Michael Duerig and Tjipke A. van der Plaats
Source: <https://www.lmc-mediaagentur.de/dpool>
---


Как прочитать свойство напрямую из его ресурса?
===============================================

    if ReadPropertyValue('Form1.Button1', 'width') > 1000 then
      ShowMessage('You are about to create a big button!');
     
    function TForm1.ReadProp(r: TReader): string;
    begin
      result := '';
      {Determine the value type of the property, read it with the appropriate method of TReader
      and convert it to string. Not all value types are implemented here but you get the idea.}
      case r.NextValue of
        vaInt8, vaInt16, vaInt32:
          result := IntToStr(r.ReadInteger);
        vaExtended:
          result := FloatToStr(r.ReadFloat);
        vaString:
          result := r.ReadString;
        else
          r.SkipValue;  {Not implemented}
      end;
    end;
     
     
    procedure TForm1.ReadRes(PropPath: string; r: TReader);
    var
      p: string;
    begin
      {Skip the class name}
      r.ReadStr;
      {Construct the property path}
      if PropPath = '' then
        p := r.ReadStr
      else
        p := PropPath + '.' + r.ReadStr;
      {Read all properties and its values and fill them into the memo}
      while not r.EndOfList do
        Memo1.Lines.Add(p + '.' + r.ReadStr + ' = ' + ReadProp(r));
      {Skip over the end of the list of the properties of this component}
      r.CheckValue(vaNull);
      {Recursively read the properties of all sub-components}
      while not r.EndOfList do
      begin
        ReadRes(p, r);
        r.CheckValue(vaNull);
      end;
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      strm: TResourceStream;
      Reader: TReader;
    begin
      strm := TResourceStream.Create(HInstance, 'TForm1', RT_RCDATA);
      Reader := TReader.Create(strm, 1024);
      try
        Memo1.Clear;
        Reader.ReadSignature;
        ReadRes('', Reader);
      finally
        Reader.Free;
        strm.Free;
      end;
    end;
     
     
    Only one small problem.
    r.SkipValue was protected (in D5) but I hacked that out with the following code:
     
     
    type THackReader = class(TReader);
    { ... }
      THackReader(r).SkipValue;

