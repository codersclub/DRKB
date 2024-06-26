---
Title: Регулярные выражения
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Регулярные выражения
====================

It is possible to use regular expressions in Delphi thanks to their
implementation inside "Microsoft(r) Windows(r) Script". First of all I
want to say that this article isn\'t a theoretical analisys of the
regular expressions but an explanation of how to use them in Delphi.
First of all I suggest you to download the latest version of
"Microsoft(r) Windows(r) Script" at the following url:

<https://msdn.microsoft.com/downloads/default.asp?URL=/downloads/sample.asp?url=/msdn-files/027/001/733/msdncompositedoc.xml>

Download the desired package. Once downloaded, run it to install.

It will be installed Microsoft(r) Windows(r) Script wich containes:

-  Visual Basic(r) Script Edition (VBScript.) Version 5.6,
-  JScript(r) Version 5.6, Windows Script Components,
-  Windows Script Host 5.6,
-  Windows Script Runtime Version 5.6.

We are interested in the implementation of regular expressions, which is
in the file "vbscript.dll". Every time you will want to run a program,
wich exploits regular expressions by using "Microsoft(r) Windows(r)
Script", on a given computer, it will be needed to copy the file
"vbscript.dll" on the target computer and register it with the
following command line:

    regsvr32 vbscript.dll

Note that the auto-installing package, you have downloaded from the
internet, automatically do it.

Now let\'s go to import the type library in Delphi:

In the delphi menu, select "Project" then "Import type library": it
shows a mask containing a list. Inside the list select "Microsoft
VBScript Regular Expressions" (followed by a version number). It is
possible that there are more then one item with this name (it only
changes the version number): in this situation select the item with the
higher version number. In date September the 23th 2002, the package that
can be downloaded from Microsoft\'s internet site returns the following
value: `"Microsoft VBScript Regular Expressions 5.5 (Version 5.5)"`.

This version supplies the following "Class Names":
TRegExp, TMatch, TMatchCollection, TSubMatches.

- Define the name of the pascal unit, wich will be the type library import unit, in
the edit box "Unit dir name".
 
- Uncheck the checkbox "Generate Component Wrapper" (we are only interested in the
pascal source)
and press the button "Create Unit" to create the import unit.
 
Let's assume to have the latest available version in date
September the 23th i.e.
 
    "Microsoft VBScript Regular Expressions 5.5 (Version 5.5)"
 
The following "interface" are declared:
     
      IRegExp = interface;
      IMatch = interface;
      IMatchCollection = interface;
      IRegExp2 = interface;
      IMatch2 = interface;
      IMatchCollection2 = interface;
      ISubMatches = interface;

IRegExp and IRegExp2 are different versions (IRegExp2 is the latest)
of the same "interface". Idem for the other "interface".
 
Then there are the declarations of CoClasses defined in Type Library.
We map each CoClass to its Default Interface:

      RegExp = IRegExp2;
      Match = IMatch2;
      MatchCollection = IMatchCollection2;
      SubMatches = ISubMatches;

IRegExp2 is the "main" "interface":
     
**Properties:**
 
1. `property Pattern: WideString read Get_Pattern write Set_Pattern;`  
   regular expression

2. `property IgnoreCase: WordBool read Get_IgnoreCase write Set_IgnoreCase;`  
   "case insensitive" search (TRUE o FALSE)

3. `property Global: WordBool read Get_Global write Set_Global;`  
   TRUE for global search on the input string of the method "Execute",  
   FALSE if you want to stop after the first match

4. `property Multiline: WordBool read Get_Multiline write Set_Multiline;`  
   If the input string contains '\n' charachters, it contains several
   rows. If Multiline = FALSE (default value) then the regular
   expression must be tested distinctly on each row.  
   If Multiline = TRUE the regular expression must be tested on the
   whole input string.
 

**Methods:**
 
- `function  Execute(const sourceString: WideString): IDispatch; safecall;`  
  it returns a Matches collection object containing a match object
  for each succesfull match

- `function  Test(const sourceString: WideString): WordBool; safecall;`  
  it returns TRUE if the regular expression can succesfully be
  matched against the string

- `function  Replace(const sourceString: WideString; const replaceString: WideString): WideString; safecall;`  
  it replaces all the matches, inside "sourceString" with the
  replace string "replaceString".  
  You can use the values $1, $2, $3, ... in order to define a
  replace-string made by substrings of the pattern.

IMatchCollection2 collects all the matches.  
For example:
     
    var
      i: integer;
      MatchesCollection: IMatchCollection2;
    {...}
    MatchesCollection := Execute(InputStr) as IMatchCollection2;
     
    for i := 1 to MatchesCollection.Count - 1 do
      begin
        Memo1.Lines.Add((MatchesCollection.Item[i] as IMatch2).Value);
      end;
    {...}
     
Remember that you can substitute the "interface" types with
the CoClass types:

    RegExp            (IRegExp2)
    Match             (IMatch2)
    MatchCollection   (IMatchCollection2)
    SubMatches        (ISubMatches)

The main properties of IMatchCollection2 are:
     
- `property Item[index: Integer]: IDispatch read Get_Item; default;`  
  Matches array; index in [0..n]
 
- `property Count: Integer read Get_Count;`  
  Number of matches

The Item property returns "IMatch2" values.

Match2 represents each succesfull match.

The main properties are:

- `property Value: WideString read Get_Value;`  
  matched value or text

- `property FirstIndex: Integer read Get_FirstIndex;`  
  the position within the original string where the match occurred.  
  Note that the first position in a string is 0

- `property Length: Integer read Get_Length;`  
  length of the matched string

- `property SubMatches: IDispatch read Get_SubMatches;`  
  substrings ($1, $2, $3, ...)


ISubMatches collects the values of $1, $2, $3, ...
     
The main properties are:
     
- `property Item[index: Integer]: OleVariant read Get_Item; default;`  
  for example Item[3] is $3; note that index values start from 0
 
- `property Count: Integer read Get_Count;`  
  number of substrings


Short description of $1, $2, $3, ...  
They are defined in the following manner (let's scan the pattern from left to right):

- $1 is the substring from the first open parenthesis to the corrisponding closed one.
- $2 is the substring from the second open parenthesis to the corrisponding closed one.
- $3 is the substring from the third open parenthesis to the corrisponding closed one.
- ....

For example: let's consider the following pattern
     
    (FTP|HTTP)://([_a-z\d-]+(\.[_a-z\d-]+)+)((/[ _a-z\d-\\\.]+)+)*
     
    $1 = FTP|HTTP
    $2 = [_a-z\d-]+(\.[_a-z\d-]+)+
    $3 = \.[_a-z\d-]+
    $4 = (/[ _a-z\d-\\\.]+)+
    $5 = /[ _a-z\d-\\\.]+


Finally a couple of examples:
     
- Save an html file from the internet and name it "Test.htm".
- Create a new delphi project: drop 2 buttons (btSearch e btReplace)
  and a Memo (Memo1);
- of course include in the "uses" directive the
name of the import unit.

```delphi
//returns all links in "Test.htm" and $1, $2, $3, etc...
procedure TForm1.btSearchClick(Sender: TObject);
var
  i, j: integer;
  FileStream: TFileStream;
  InputStr, InputFile: string;
  RegExp1: RegExp;
  MatchCollection1: MatchCollection;
  Match1: Match;
  SubMatches1: ISubMatches;
begin
  //
  InputFile := 'Test.htm'; //input file
 
  FileStream := TFileStream.Create(InputFile, fmOpenRead);
 
  SetLength(InputStr, FileStream.Size);
 
  FileStream.Read(InputStr[1], FileStream.Size);
  //load "Test.htm" in InputString
 
  RegExp1 := CoRegExp.Create;
 
  with RegExp1 do
    begin
      //I want to search all links
      Pattern := '(FTP|HTTP)://([_a-z\d-]+(\.[_a-z\d-]+)+)' +
                 '((/[ _a-z\d-\\\.]+)+)*';
      IgnoreCase := True; //"case insensitive" search
      Global := True; //I want to search all the matches
      MatchCollection1 := Execute(InputStr) as MatchCollection;
    end;
 
  for i := 0 to MatchCollection1.Count - 1 do
    begin
      Match1 := MatchCollection1.Item[i] as Match;
      Memo1.Lines.Add(Match1.Value);
      SubMatches1 := Match1.SubMatches as SubMatches;
      for j := 0 to SubMatches1.Count - 1 do
        begin
          Memo1.Lines.Add('          ' + '$' + inttostr(j + 1) +
                          ' = ' + VarToStr(SubMatches1.Item[j]));
        end;
    end;
 
  RegExp1 := nil;
 
  FileStream.Free;
 
end;
 
 
//I replace all links in "Test.htm" with a new string and
//save the result string in the new file "Test_out.htm"
procedure TForm1.btReplaceClick(Sender: TObject);
var
  i: integer;
  InFileStream, OutFileStream: TFileStream;
  InputStr, OutputStr, InputFile, OutputFile: string;
  RegExp1: RegExp;
  MatchCollection1: MatchCollection;
  Match1: Match;
  SubMatches1: ISubMatches;
begin
  InputFile := 'Test.htm';
  OutputFile := 'Test_out.htm';
  InFileStream := TFileStream.Create(InputFile, fmOpenRead);
  SetLength(InputStr, InFileStream.Size);
  InFileStream.Read(InputStr[1], InFileStream.Size);
  InFileStream.Free;
  RegExp1 := CoRegExp.Create;
  with RegExp1 do
    begin
      Pattern := '(FTP|HTTP)://([_a-z\d-]+(\.[_a-z\d-]+)+)' +
                 '((/[ _a-z\d-\\\.]+)+)*';
      IgnoreCase := True;
      Global := True;
      OutputStr := Replace(InputStr, '$2');
    end;
  OutFileStream := TFileStream.Create(OutputFile, fmCreate);
  SetLength(OutputStr, Length(OutputStr));
  OutFileStream.Write(OutputStr[1], Length(OutputStr));
  OutFileStream.Free;
  RegExp1 := nil;
  ShowMessage('replace completed');
end;
```
