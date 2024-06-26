---
Title: Parsing XML
Date: 01.01.2003
---


Parsing XML
===========

```delphi
{
 
Here I will show one way to parse XML document
 
The main concept of XML is using containers for XML objects -
so we will use Tree concept while building our XML object from XML document.
 
XML text uses containers (<TAG ... >...</TAG>) or simple definitions (<TAG ... />)
in each TAG we can use parameters (<TAG key1="value1" key2="value2">... <SIMPLE key3="value3"> ...</TAG>)
 
Finally we will have an array of objects, describing XML tags. Every object of this
class will have an array of children if needed, and a hash to describe properties of it.
 
For example if we have a text
 
<UL name="xxx">
  <LI name="xxx1"/>
  <LI name="xxx2"/>
  <LI name="xxx3"/>
  <LI name="xxx4"/>
</UL>
 
we will have one root object (named "UL") in wich we will have 4 children
(named "LI" with different sets of properties - from "NAME"="xxx1" to "NAME"="xxx4")
 
This is not a trivial task - so we will make a unit to solve this...
I will try to comment some here...
 
if you have any comments for this unit - write to me: sunworx@mail.ru; yz@infoteh.ru
 
}
unit YZXMLParser;
 
interface
 
uses
  SysUtils, ComCtrls;
 
type 
  THashElement = record
    Key, Value: string;
  end;
 
type 
  THashElementArr = array of THashElement;
 
 
  // here  we declare a THash class to use in our parser
  // The concept of THash is to retreive named values from an array
  // Hash is an array where index is a string (example V[Key]=value,
  // whehe Key and Value are of type string)
 
  // The main purpose of this class is to rerurn a value of a String-named key
  //(example: s:=hash['someValue'])
 
 
  // the description of a hash element we use
 
type 
  THash = class(TObject)
  private
    Arr: THashElementArr;
    function GetValue(Key: string): string;
    procedure SetValue(Key: string; const VValue: string);
    function GetKeys: StrArr;
    function GetValues: StrArr;
    function GetCount: Integer;
    function Getempty: Boolean;
  public
    property Value[Key: string]: string read GetValue write SetValue; default;
    property Values: StrArr read GetValues;
    property Keys: StrArr read GetKeys;
    property Count: Integer read GetCount;
    property Empty: Boolean read Getempty;
    procedure Clear;
    constructor Create;
    destructor Destroy; override;
  end;
 
  TYZHash = THash;
 
 
type
 
  // Here we declare some definitions for our parser to know what
  // identifier we would receive next in our text
  // these  values will be used in the result of WhatNext() function which will scan text for keys
 
  TYZXMLMarker = (xmlOpenTag, xmlCloseTagShort, xmlCloseTag, xmlCloseTagLong,
    xmlEOF, xmlIdentifier, xmlunknown); /*
 
  Because we use recursive definition of our class(as TreeView, where we declare children of
    the same type in opur type 
    declaration) we must use forward declaration
    */
 
 
  // The definition of a TAG class
 
 
  TYZXMLTag  = class;
  TYZXMLTags = array of TYZXMLTag;
 
  TYZXMLTag = class(TObject)
  private
    FData: TYZHash;
    FParent: TYZXMLTag;
    FName: string;
 
    function GetValue(AName: string): string;
    procedure SetName(const Value: string);
    procedure SetValue(AName: string; const Value: string);
    function GetCount: Integer;
    function GetValueNames: strarr;
 
  public
    Children: TYZXMLTags; // these are our child nodes
    Text: string;
 
 
    property Name: string read FName write SetName; // name of a tag
    property Values[AName: string]: string read GetValue write SetValue;
      default; // values of properties of a tag (hash values)
    property ValueNames: strarr read GetValueNames;
    // array of strings returniong names of all props of this tag
    property Count: Integer read GetCount;
    // a count of children of a tag (if this tag is a container)
 
    function SkipSpaces(var AData: string; var APos: Integer;
      RememberBreaks: Boolean = False): Char;
    // internal. for skip spaces (also CR or LF or other non-text chars) while parsing text
 
    function ParseValue(var AData: string; var APos: Integer): Boolean;
    // parse value (calling when found a parameter of a tag)
    function ParseName(var AData: string; var APos: Integer): Boolean;
    // parse key of parameter in a tag
 
    // these two procs used to parse any text found while parsing XML
    function ParseString(var AData: string; var APos: Integer;
      RememberBreaks: Boolean = False): string;
    function ParseQuotedString(var AData: string; var APos: Integer;
      QIndef: Char = '"'): string;
 
    // returnes the type of next identifier in XML
    function WhatNext(var AData: string; var APos: Integer;
      var ANext: Integer; RememberBreaks: Boolean = False): TYZXMLMarker;
 
 
    // This is a main procedure of our class - AData is a string,
    // containing all XML data (you can use TMemo.Text, for example, as a parameter of AData)
    function ParseXML(var AData: string; var APos: Integer): Boolean;
 
    // This function returnes a text string, built based on data, stored in an object.
    function GenerateXML(var AData: string; ATab: string = ''): Boolean;
 
    // returnes char from string at specified pos (#0 if not in range)
    function CharAt(var S: string; APos: Integer): Char;
 
 
    function TagNameExists(AName: string): Boolean;
 
    // Adds a child to children array of a current tag
 
    function AddChild: TYZXMLTag;
 
    // Initializes current tag and deletes all existing children
    procedure Clear; virtual;
 
    constructor Create(AParent: TYZXMLTag); virtual;
    destructor Destroy; virtual;
  end;
 
 
type 
  TYZXMLParser = class(TYZXMLTag)
  private
    Header: TYZHash;
    procedure _BuildTreeView(ATreeView: TTreeView; ANode: TTreeNode; ATag: TYZXMLTag);
  public
    property HeaderValues: TYZHash read Header;
 
    procedure BuildTreeView(ATreeView: TTreeView);
    function Parse(AData: string): Boolean;
    function Generate(var AData: string): Boolean;
    constructor Create;
    destructor Destroy;
  end;
 
implementation
 
//==============================================================================
 
{ TYZXMLTag }
 
function TYZXMLTag.AddChild: TYZXMLTag;
begin
  setlength(children, Length(children) + 1);
  Result := TYZXMLTag.Create(Self);
  children[Length(children) - 1] := Result;
end;
 
//------------------------------------------------------------------------------
 
procedure TYZXMLTag.Clear;
var 
  i: Integer;
begin
  for i := 0 to Count - 1 do if children[i] <> nil then Children[i].Destroy;
  setlength(children, 0);
  FData.Clear;
  Text := '';
end;
 
//------------------------------------------------------------------------------
 
constructor TYZXMLTag.Create(AParent: TYZXMLTag);
begin
  inherited Create;
  FData   := TYZHash.Create;
  FParent := AParent;
  Clear;
end;
 
//------------------------------------------------------------------------------
 
destructor TYZXMLTag.Destroy;
begin
  Clear;
  FData.Destroy;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.GetCount: Integer;
begin
  Result := Length(children);
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.GetValue(AName: string): string;
begin
  Result := FData[AName];
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.ParseName(var AData: string; var APos: Integer): Boolean;
begin
  Result := False;
  FName  := ParseString(AData, APos);
  if fname = '' then Exit;
  Result := True;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.ParseQuotedString(var AData: string; var APos: Integer;
  QIndef: Char = '"'): string;
var 
  i: Integer;
  skipnext: Boolean;
  z: Char;
begin
  Result := '';
  if CharAt(AData, APos) <> QIndef then Exit;
  i        := APos;
  skipnext := True;
  repeat
    if not skipnext then
    begin
      if charat(AData, I) = '\' then SkipNext := True 
      else
      begin
        z := charat(AData, I);
        if (Z = QIndef) or (z = #0) then
        begin
          Result := Copy(AData, APos + 1, I - APos - 1);
          //          result:=exch(result,'\','');
          APos := I + 1;
          Exit;
        end;
      end;
    end 
    else 
      skipnext := False;
    Inc(i);
  until False;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.ParseString(var AData: string; var APos: Integer;
  RememberBreaks: Boolean = False): string;
const 
  extsym: string = '=<>;?*/';
var 
  nxt: Char;
  x1, x2, i: Integer;
begin
  Result := '';
  nxt    := SkipSpaces(AData, APos, RememberBreaks);
  if nxt = #0 then Exit;
  if (nxt = '"') or (nxt = '''') then 
  begin 
    Result := ParseQuotedString(AData, APos); 
    Exit; 
  end;
  x1  := APos;
  i   := x1;
  nxt := CharAt(AData, i);
  while ((Ord(nxt) <= 32) or (Pos(nxt, extsym) > 0)) and (nxt <> #0) do 
  begin 
    Inc(i); 
    nxt := CharAt(AData, i); 
  end;
  APos := i;
  X1 := APos;
  while (Ord(nxt) > 32) and (Pos(nxt, extsym) <= 0) do 
  begin 
    Inc(i); 
    nxt := CharAt(AData, i); 
  end;
  x2 := i - x1;
  Result := Copy(AData, x1, x2);
  APos := i;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.ParseValue(var AData: string; var APos: Integer): Boolean;
var 
  n, v: string;
  i, x: Integer;
begin
  Result := False;
  n := parseString(AData, APos);
  if n = '' then Exit;
  if skipspaces(AData, APos) <> '=' then Exit;
  Inc(APos);
  V := parseString(AData, APos);
  fdata[n] := dequote(v);
  Result := True;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.ParseXML(var AData: string; var APos: Integer): Boolean;
var 
  N: TYZXMLMarker;
  nxt: Integer;
  isLong: Boolean;
  inTag: Boolean;
begin
  isLong := False;
  Result := False;
  Clear;
  if WhatNext(AData, APos, nxt) <> xmlOpenTag then Exit;
  APos := nxt;
  if WhatNext(AData, APos, nxt) <> xmlIdentifier then Exit;
  Result := ParseName(AData, APos);
  if not Result then Exit;
  intag  := True;
  Result := False;
  while True do
  begin
    N := WhatNext(AData, APos, nxt, (not intag and islong and (Count > 0)));
    case N of
      xmlEOF: Exit;
      xmlCloseTagLong: 
        begin 
          Result := True; 
          if islong then APos := nxt; 
          if (Text <> '') and (Count > 0) then 
          begin 
            Text := exch(Text, #13#10#13#10, #13#10); 
          end;
 
          Exit; 
        end;
      xmlCloseTagShort: 
        begin 
          Result := (not IsLong) and intag; 
          if Result then APos := nxt; 
          Exit; 
        end;
      xmlOpenTag: 
        begin 
          if islong then Result := AddChild.ParseXML(AData, APos) 
          else 
          begin 
            Result := False; 
            Exit; 
          end; 
          if not Result then Exit; 
        end;
      xmlCloseTag: 
        begin 
          IsLong := True; 
          APos   := nxt; 
          intag  := False; 
        end;
      xmlIdentifier: 
        begin 
          if intag then parsevalue(AData, APos) 
          else 
            Text := Text + ParseString(AData, APos, True) 
        end;
      xmlUnknown: 
        begin 
          Result := True; 
          Exit; 
        end;
    end;
  end;
end;
 
//------------------------------------------------------------------------------
 
procedure TYZXMLTag.SetName(const Value: string);
begin
  FName := Value;
end;
 
//------------------------------------------------------------------------------
 
procedure TYZXMLTag.SetValue(AName: string; const Value: string);
begin
  FData[AName] := Value;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.SkipSpaces(var AData: string; var APos: Integer;
  RememberBreaks: Boolean = False): Char;
var 
  L: Integer;
  P: Char;
begin
  L := Length(AData);
  while APos <= L do
  begin
    P := AData[APos];
    if Ord(p) > 32 then 
    begin 
      Result := p; 
      Exit; 
    end 
    else if rememberbreaks then
    begin
      if Pos(p, #13#9' ') > 0 then
        Text := Text + ' ';
    end;
    Inc(APos);
  end;
  Result := #0;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.CharAt(var S: string; APos: Integer): Char;
begin
  Result := #0;
  if (Length(s) < APos) or (APos < 1) then Exit;
  Result := s[APos];
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.WhatNext(var AData: string; var APos: Integer;
  var ANext: Integer; RememberBreaks: Boolean = False): TYZXMLMarker;
var 
  s: string;
  C: Char;
  P: Integer;
begin
  Result := xmlEOF;
  P := APos;
  C := SkipSpaces(AData, APos);
  P := APos;
  ANext  := P;
  if C = #0 then Exit;
 
  if C = '<' then if CharAt(AData, P + 1) = '/' then
    begin
      Inc(P, 2);
      s := parsestring(AData, P);
      if (uppercase(s) = uppercase(FName)) and (SkipSpaces(AData, P) = '>') then
      begin 
        ANext := P + 1;
        Result := xmlCloseTagLong; 
        Exit; 
      end 
      else
      begin
        if TagNameExists(s) then
        begin
          Result := xmlCloseTagLong;
          ANext := APos;
          Exit;
        end;
        ANext  := P + 1;
        Result := xmlCloseTagLong;
        Exit;
      end;
    end;
 
  if C = '<' then 
  begin 
    ANext := P + 1;
    Result := xmlOpenTag; 
    Exit; 
  end;
 
  if C = '>' then 
  begin 
    ANext := P + 1;
    Result := xmlCloseTag; 
    Exit; 
  end;
  if C = '/' then if CharAt(AData, P + 1) = '>' then 
    begin 
      ANext := P + 2;
      Result := xmlCloseTagShort; 
      Exit;
    end;
  ANext := P;
  parsestring(AData, ANext);
  Result := xmlIdentifier;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.GetValueNames: strarr;
begin
  Result := FData.Keys;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.GenerateXML(var AData: string; ATab: string = ''): Boolean;
var 
  valDelimiter: string;
  spc: string;
  i: Integer;
  a: strarr;
begin
  spc := ATab + #9;
  if FData.Count < 5 then valDelimiter := ' ' 
  else 
    valDelimiter := #13#10 + spc;
  AData := AData + #13#10 + ATab + '<' + FName;
  a     := FData.keys;
  for i := 0 to Length(a) - 1 do
  begin
    AData := AData + valDelimiter + a[i] + ' = "' + EnQuote(values[a[i]]) + '"';
  end;
  if (Count > 0) or (Text <> '') then
  begin
    AData := AData + '>' + Text;
    for i := 0 to Count - 1 do
    begin
      Children[i].GenerateXML(AData, ATab + #9);
    end;
    AData := AData + #13#10 + ATab + '</' + FName + '>';
  end 
  else 
    AData := AData + '/>';
  Result := True;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLTag.TagNameExists(AName: string): Boolean;
begin
  Result := AnsiUpperCase(AName) = AnsiUpperCase(Self.FName);
  if Self.FParent = nil then Exit;
  if not Result then Result := fparent.TagNameExists(AName);
end;
 
//==============================================================================
 
 
{ TYZXMLParser }
 
constructor TYZXMLParser.Create;
begin
  Header := TYZHash.Create;
  inherited Create(nil);
end;
 
//------------------------------------------------------------------------------
 
destructor TYZXMLParser.Destroy;
begin
  inherited;
  Header.Destroy;
end;
 
//------------------------------------------------------------------------------
 
procedure TYZXMLParser.BuildTreeView(ATreeView: TTreeView);
var 
  i: Integer;
begin
  //  clear;
  ATreeView.Items.Clear;
  for i := 0 to Count - 1 do _BuildTreeView(ATreeView, nil, children[i]);
end;
 
//------------------------------------------------------------------------------
 
procedure TYZXMLParser._BuildTreeView(ATreeView: TTreeView; ANode: TTreeNode;
  ATag: TYZXMLTag);
var 
  i: Integer;
  N: TTreeNode;
begin
  N := ATreeView.Items.AddChildObject(ANode, ATag.Name + ' ' + FData['ID'], Pointer(ATag));
  for i := 0 to ATag.Count - 1 do
  begin
    if ATag.children[i] <> nil then _BuildTreeView(ATreeView, N, ATag.children[i]) 
    else 
      ATreeView.Items.AddChild(N, 'nil');
  end;
  N.Expanded := True;
end;
 
//------------------------------------------------------------------------------
 
function TYZXMLParser.Parse(AData: string): Boolean;
var 
  x1, x2, X, i: Integer;
  s: string;
  tmp: TYZXMLTag;
  a: strarr;
  N: TYZXMLMarker;
begin
  X := 1;
  Self.SkipSpaces(AData, X);
  x2 := -1;
  Result := False;
  Clear;
  Header.Clear;
  x1 := Pos('<?', AData);
  if x1 >= X then
  begin
    x2 := Pos('?>', AData);
    if x2 < X then Exit;
    s := uppercase(Copy(AData, x1 + 2, 4));
    if Pos('XML ', s) <> 1 then Exit;
    s   := '<xml ' + Copy(AData, x1 + 6, x2 - x1 - 6) + '/>';
    tmp := TYZXMLTag.Create(nil);
    tmp.ParseXML(s, x);
    a := tmp.ValueNames;
    for i := 0 to Length(a) - 1 do
      Header[a[i]] := tmp.Values[a[i]];
    tmp.Destroy;
    x := x2 + 2;
  end;
  Result := True;
  repeat
    N := whatnext(AData, X, x1);
    case N of
      xmlOpenTag: Result := Result and AddChild.ParseXML(AData, X);
      xmlIdentifier: 
        begin 
          if Text <> '' then Text := Text + ' '; 
          Text := Text + parsestring(AData, X, True); 
        end;
      else 
        Parsestring(AData, X);
    end;
  until skipspaces(adata, x) = #0;
  //  if not result then ShowMessage('Error Parsing: '+inttostr(X));
end;
 
 
 
function TYZXMLParser.Generate(var AData: string): Boolean;
var 
  i: Integer;
  a: strarr;
begin
  Header['Date'] := DateTimeToStr(now);
  a := header.Keys;
 
  AData := '<?xml';
  for i := 0 to Length(a) - 1 do
    AData := AData + ' ' + a[i] + '="' + Header[a[i]] + '"';
 
  AData  := AData + '?>'#13#10 + Text;
  Result := True;
  for i := 0 to Length(children) - 1 do
  begin
    Result := Result and children[i].generatexml(AData);
  end;
end;
 
//==============================================================================
 
 
// procedures of THash class
 
 
//==============================================================================
 
{THASH CLASS}
 
 
procedure THash.Clear;
begin
  SetLength(Arr, 0);
end;
 
constructor THash.Create;
begin
  inherited;
  Clear;
end;
 
//------------------------------------------------------------------------------
 
destructor THash.Destroy;
begin
  Clear;
  inherited;
end;
 
//------------------------------------------------------------------------------
 
function THash.GetCount: Integer;
begin
  Result := Length(Arr);
end;
 
//------------------------------------------------------------------------------
 
function THash.Getempty: Boolean;
begin
  Result := Length(Arr) = 0;
end;
 
function THash.GetKeys: StrArr;
var 
  i: Integer;
begin
  SetLength(Result, Length(arr));
  for i := 0 to Length(Result) - 1 do
    Result[i] := arr[i].Key;
end;
 
//------------------------------------------------------------------------------
 
function THash.GetValue(Key: string): string;
var 
  i: Integer;
  r: Boolean;
begin
  Result := '';
  i      := 0; 
  r      := False;
  while (i < Length(Arr)) and (not r) do
  begin
    if AnsiUpperCase(arr[i].key) = AnsiUpperCase(Key) then 
    begin 
      Result := Arr[i].Value; 
      r := True;
    end;
    i := i + 1;
  end;
end;
 
//------------------------------------------------------------------------------
 
function THash.GetValues: StrArr;
var 
  i: Integer;
begin
  SetLength(Result, Length(arr));
  for i := 0 to Length(Result) - 1 do
    Result[i] := arr[i].Value;
end;
 
//------------------------------------------------------------------------------
 
procedure THash.SetValue(Key: string; const VValue: string);
var 
  i, j: Integer;
  r: Boolean;
  E: THashElementArr;
begin
  if VValue <> '' then
  begin
    i := 0; 
    r := False;
    while (i < Length(Arr)) and not r do
    begin
      if AnsiUpperCase(arr[i].key) = AnsiUpperCase(Key) then 
      begin 
        Arr[i].Value := VValue; 
        r := True;
      end;
      i := i + 1;
    end;
    if not r then 
    begin 
      SetLength(Arr, Length(arr) + 1);
      arr[Length(arr) - 1].Key   := Key;
      arr[Length(arr) - 1].Value := Vvalue; 
    end;
  end;
 
  SetLength(E, Length(Arr));
  for i := 0 to Length(arr) - 1 do E[i] := Arr[i];
  SetLength(arr, 0);
  for i := 0 to Length(E) - 1 do if (E[i].Key <> '') and (E[i].Value <> '') then
    begin
      j := Length(arr);
      setlength(arr, j + 1);
      arr[j] := E[i];
    end;
end;
 
end.
```
