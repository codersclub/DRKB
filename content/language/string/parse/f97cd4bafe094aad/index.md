---
Title: Функции для парсинга строк
Date: 01.01.2007
---


Функции для парсинга строк
==========================

::: {.date}
01.01.2007
:::

Здесь представлен модуль, в котором я разметил много методов для
подобной работы. Некоторые функции поименованы по-шведски, но, может
быть, Вы сможете понять, что они делают.

Вам потребуется один из методов, называющийся stringreplaceall, который
принимает при параметра - исходную строку, подстроку для поиска и
подстроку для замены, и возвращает измененную строку. Будьте осторожны,
если Вы меняется одну подстроку на другую, чьей частью является первая.
Вы должны делать это в два прохода, или Вы попадете в бесконечный цикл.

Так, если Вы имеете текст, содержащий слово Joe, и Вы хотите все его
вхождения изменить на Joey, то Вы должны сделать сперва нечто похожее
на:

text := stringreplaceall(text, \'Joe\', \'Joeey\');

И потом:

text := stringreplaceall(text, \'Joeey\', \'Joey\');

    unit sparfunc;
     
    interface
     
    uses
      sysutils, classes;
     
    function antaltecken (orgtext,soktext : string) : integer;
    function beginsWith (text,teststreng : string):boolean;
    function endsWith (text,teststreng : string):boolean;
    function hamtastreng (text,strt,slut : string):string;
    function hamtastrengmellan (text,strt,slut : string):string;
    function nastadelare (progtext : string):integer;
    function rtf2sgml (text : string) : string;
    function sgml2win(text : string) : string;
    function sgml2mac(text : string) : string;
    function sgml2rtf(text : string) : string;
    function sistamening(text : string) : string;
    function stringnthfield (text,delim : string; vilken : integer) : string;
    function stringreplace (text,byt,mot : string) : string;
    function stringreplaceall (text,byt,mot : string) : string;
    function text2sgml (text : string) : string;
    procedure SurePath (pathen : string);
    procedure KopieraFil (infil,utfil : string);
    function LasInEnTextfil (filnamn : string) : string;
     
    implementation
     
    function LasInEnTextfil (filnamn : string) : string;
    var
      infil : textfile;
      temptext, filtext : string;
    begin
      filtext := '';
      //Oppna angiven fil och las in den
      try
        assignfile (infil,filnamn); //Koppla en textfilsvariabel till pathname
        reset (infil); //Oppna filen
        //Sa lange vi inte natt slutet
        while not eof(infil) do
        begin
          readln (infil,temptext); //Las in en rad
          filtext := filtext+temptext; //Lagg den till variabeln SGMLTEXT
        end;
      finally
        closefile (infil); //Stang filen
      end;
      result := filtext;
    end;
     
    procedure KopieraFil (infil,utfil : string);
    var
      InStream : TFileStream;
      OutStream : TFileStream;
    begin
      InStream := TFileStream.Create(infil,fmOpenRead);
      try
        OutStream := TFileStream.Create(utfil,fmOpenWrite or fmCreate);
        try
          OutStream.CopyFrom(InStream,0);
        finally
          OutStream.Free;
        end;
      finally
        InStream.Free;
      end;
    end;
     
    procedure SurePath (pathen : string);
    var
      temprad,del1 : string;
      antal : integer;
    begin
      antal := antaltecken (pathen,'\');
      if antal < 3 then
        createdir(pathen)
      else
      begin
        if pathen[length(pathen)]  <  >  '\' then
          pathen := pathen+'\';
        pathen := stringreplace(pathen,'\','/');
        del1 := copy(pathen,1,pos('\',pathen));
        pathen := stringreplace(pathen,del1,'');
        del1 := stringreplace(del1,'/','\');
        createdir (del1);
        while pathen  <  >  '' do
        begin
          temprad := copy(pathen,1,pos('\',pathen));
          pathen := stringreplace(pathen,temprad,'');
          del1 := del1+ temprad;
          temprad := '';
          createdir(del1);
        end;
      end;
    end;
     
    function antaltecken (orgtext,soktext : string) : integer;
    var
      i,traffar,soklengd : integer;
    begin
      traffar := 0;
      soklengd := length(soktext);
      for i := 1 to length(orgtext) do
        if soktext = copy(orgtext,i,soklengd) then
          traffar := traffar +1;
      result := traffar;
    end;
     
    function nastadelare (progtext : string):integer;
    var
      i,j : integer;
    begin
      i := pos('.',progtext);
      j := pos('!',progtext);
      if (j < i) and (j > 0) then
        i := j;
      j := pos('!',progtext);
      if (j < i) and (j > 0) then
        i := j;
      j := pos('?',progtext);
      if (j < i) and (j > 0) then
        i := j;
      result := i;
    end;
     
    function stringnthfield (text,delim : string; vilken : integer) : string;
    var
      start,slut,i : integer;
      temptext : string;
    begin
      start := 0;
      if vilken  > 0 then
      begin
        temptext := text;
        if vilken = 1 then
        begin
          start := 1;
          slut := pos (delim,text);
        end
        else
        begin
          for i:= 1 to vilken -1 do
          begin
            start := pos(delim,temptext)+length(delim);
            temptext := copy(temptext,start,length(temptext));
          end;
          slut := pos (delim,temptext);
        end;
        if start  > 0 then
        begin
          if slut = 0 then
            slut := length(text);
          result := copy (temptext,1,slut-1);
        end
        else
          result := text;
      end
      else
        result := text;
    end;
     
    function StringReplaceAll (text,byt,mot : string ) :string;
    {Funktion for att byta ut alla forekomster av en strang mot en
    annan strang in en strang. Den konverterade strangen returneras.
    Om byt finns i mot maste vi ga via en temporar variant!!!}
    var
      plats : integer;
    begin
      while pos(byt,text)  >  0 do
      begin
        plats := pos(byt,text);
        delete (text,plats,length(byt));
        insert (mot,text,plats);
      end;
      result := text;
    end;
     
    function StringReplace (text,byt,mot : string ) :string;
    {Funktion for att byta ut den forsta forekomsten av en strang mot en
    annan strang in en strang. Den konverterade strangen returneras.}
    var
      plats : integer;
    begin
      if pos(byt,text)  >  0 then
      begin
        plats := pos(byt,text);
        delete (text,plats,length(byt));
        insert (mot,text,plats);
      end;
      result := text;
    end;
     
    function hamtastreng (text,strt,slut : string):string;
    {Funktion for att hamta ut en delstrang ur en annan strang.
    Om start och slut finns i text sa returneras en strang dar start
    ingar i borjan och fram till tecknet fore slut.}
    var
      stplats,slutplats : integer;
      resultat : string;
    begin
      resultat :='';
      stplats := pos(strt,text);
      if stplats  > 0 then
      begin
        text := copy (text,stplats,length(text));
        slutplats := pos(slut,text);
        if slutplats  > 0 then
          resultat := copy(text,1,slutplats-1);
      end;
      result := resultat;
    end;
     
    function hamtastrengmellan (text,strt,slut : string):string;
    {Funktion for att hamta ut en delstrang ur en annan strang.
    Om start och slut finns i text sa returneras en strang dar start
    ingar i borjan och fram till tecknet fore slut.}
    var
      stplats,slutplats : integer;
      resultat : string;
    begin
      resultat :='';
      stplats := pos(strt,text);
      if stplats  > 0 then
      begin
        text := copy (text,stplats+length(strt),length(text));
        slutplats := pos(slut,text);
        if slutplats  > 0 then
          resultat := copy(text,1,slutplats-1);
      end;
      result := resultat;
    end;
     
    function endsWith (text,teststreng : string):boolean;
    {Kollar om en strang slutar med en annan strang.
    Returnerar true eller false.}
    var
      textlngd,testlngd : integer;
      kollstreng : string;
    begin
      testlngd := length(teststreng);
      textlngd := length (text);
      if textlngd  >  testlngd then
      begin
        kollstreng := copy (text,(textlngd+1)-testlngd,testlngd);
        if kollstreng = teststreng then
          result := true
        else
          result := false;
      end
      else
        result := false;
    end;
     
    function beginsWith (text,teststreng : string):boolean;
    {Funktion for att kolla om text borjar med teststreng.
    Returnerar true eller false.}
    var
      textlngd,testlngd : integer;
      kollstreng : string;
    begin
      testlngd := length(teststreng);
      textlngd := length (text);
      if textlngd  > = testlngd then
      begin
        kollstreng := copy (text,1,testlngd);
        if kollstreng = teststreng then
          result := true
        else
          result := false;
      end
      else
        result := false;
    end;
     
    function sistamening(text : string) : string;
    //Funktion for att ta fram sista meningen i en strang. Soker pa !?.
    var
      i:integer;
    begin
      i :=length(text)-1;
      while (copy(text,i,1) <  >  '.') and (copy(text,i,1) <  >  '!')
      and (copy(text,i,1) <  >  '?') do
      begin
        dec(i);
        if i =1 then
          break
     
      end;
      if i > 1 then
        result := copy(text,i,length(text))
      else
        result := '';
    end;
     
    function text2sgml(text : string) : string;
    {Funktion som byter ut alla ovanliga tecken mot entiteter.
    Den fardiga texten returneras.}
    begin
      text := stringreplaceall (text,'&','##amp;');
      text := stringreplaceall (text,'##amp','&');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'?','?');
      text := stringreplaceall (text,'?','&Aelig;');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'c','c');
      text := stringreplaceall (text,'C','C');
      text := stringreplaceall (text,'e','e');
      text := stringreplaceall (text,'E','E');
      text := stringreplaceall (text,'e','e');
      text := stringreplaceall (text,'E','E');
      text := stringreplaceall (text,'e','e');
      text := stringreplaceall (text,'E','E');
      text := stringreplaceall (text,'e','e');
      text := stringreplaceall (text,'E','E');
      text := stringreplaceall (text,'i','i');
      text := stringreplaceall (text,'I','I');
      text := stringreplaceall (text,'i','i');
      text := stringreplaceall (text,'I','I');
      text := stringreplaceall (text,'i','i');
      text := stringreplaceall (text,'I','I');
      text := stringreplaceall (text,'i','i');
      text := stringreplaceall (text,'I','I');
      text := stringreplaceall (text,'n','n');
      text := stringreplaceall (text,'N','N');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'u','u');
      text := stringreplaceall (text,'U','U');
      text := stringreplaceall (text,'u','u');
      text := stringreplaceall (text,'U','U');
      text := stringreplaceall (text,'U','U');
      text := stringreplaceall (text,'u','u');
      text := stringreplaceall (text,'u','u');
      text := stringreplaceall (text,'U','U');
      text := stringreplaceall (text,'y','y');
      text := stringreplaceall (text,'Y','Y');
      text := stringreplaceall (text,'y','y');
      text := stringreplaceall (text,'|',' ');
      result := text;
    end;
     
    function sgml2win(text : string) : string;
    {Funktion som ersatter alla entiteter mot deras tecken i
    windows. Den fardiga strangen returneras.}
    begin
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'?','?');
      text := stringreplaceall (text,'&Aelig;','?');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'A' ,'A');
      text := stringreplaceall (text,'a' ,'a');
      text := stringreplaceall (text,'a','a');
      text := stringreplaceall (text,'A','A');
      text := stringreplaceall (text,'c','c');
      text := stringreplaceall (text,'C','C');
      text := stringreplaceall (text,'e','e');
      text := stringreplaceall (text,'E','E');
      text := stringreplaceall (text,'e','e');
      text := stringreplaceall (text,'E','E');
      text := stringreplaceall (text,'e' ,'e');
      text := stringreplaceall (text,'E' ,'E');
      text := stringreplaceall (text,'e' ,'e');
      text := stringreplaceall (text,'E' ,'E');
      text := stringreplaceall (text,'i' ,'i');
      text := stringreplaceall (text,'I' ,'I');
      text := stringreplaceall (text,'i','i');
      text := stringreplaceall (text,'I','I');
      text := stringreplaceall (text,'i','i');
      text := stringreplaceall (text,'I','I');
      text := stringreplaceall (text,'i' ,'i');
      text := stringreplaceall (text,'I' ,'I');
      text := stringreplaceall (text,'n','n');
      text := stringreplaceall (text,'N','N');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'O' ,'O');
      text := stringreplaceall (text,'o' ,'o');
      text := stringreplaceall (text,'o','o');
      text := stringreplaceall (text,'O','O');
      text := stringreplaceall (text,'u','u');
      text := stringreplaceall (text,'U','U');
      text := stringreplaceall (text,'u','u');
      text := stringreplaceall (text,'U','U');
      text := stringreplaceall (text,'u' ,'u');
      text := stringreplaceall (text,'U' ,'U');
      text := stringreplaceall (text,'U','U');
      text := stringreplaceall (text,'u','u');
      text := stringreplaceall (text,'y','y');
      text := stringreplaceall (text,'Y','Y');
      text := stringreplaceall (text,'y' ,'y');
      text := stringreplaceall (text,' ','|');
      text := stringreplaceall (text,'&','&');
      result := text;
    end;
     
    function sgml2mac(text : string) : string;
    {Funktion som ersatter alla entiteter mot deras tecken i
    mac. Den fardiga strangen returneras.}
    begin
      text := stringreplaceall (text,'a',chr(135));
      text := stringreplaceall (text,'A',chr(231));
      text := stringreplaceall (text,'?',chr(190));
      text := stringreplaceall (text,'&Aelig;',chr(174));
      text := stringreplaceall (text,'a',chr(136));
      text := stringreplaceall (text,'A',chr(203));
      text := stringreplaceall (text,'a',chr(140));
      text := stringreplaceall (text,'A',chr(129));
      text := stringreplaceall (text,'A',chr(128));
      text := stringreplaceall (text,'a',chr(138));
      text := stringreplaceall (text,'A' ,chr(229));
      text := stringreplaceall (text,'a' ,chr(137));
      text := stringreplaceall (text,'a',chr(139));
      text := stringreplaceall (text,'A',chr(204));
      text := stringreplaceall (text,'c',chr(141));
      text := stringreplaceall (text,'C',chr(130));
      text := stringreplaceall (text,'e',chr(142));
      text := stringreplaceall (text,'E',chr(131));
      text := stringreplaceall (text,'e',chr(143));
      text := stringreplaceall (text,'E',chr(233));
      text := stringreplaceall (text,'e' ,chr(144));
      text := stringreplaceall (text,'E' ,chr(230));
      text := stringreplaceall (text,'e' ,chr(145));
      text := stringreplaceall (text,'E' ,chr(232));
      text := stringreplaceall (text,'i' ,chr(148));
      text := stringreplaceall (text,'I' ,chr(235));
      text := stringreplaceall (text,'i' ,chr(146));
      text := stringreplaceall (text,'I' ,chr(234));
      text := stringreplaceall (text,'i' ,chr(147));
      text := stringreplaceall (text,'I' ,chr(237));
      text := stringreplaceall (text,'i' ,chr(149));
      text := stringreplaceall (text,'I' ,chr(236));
      text := stringreplaceall (text,'n',chr(150));
      text := stringreplaceall (text,'N',chr(132));
      text := stringreplaceall (text,'o',chr(152));
      text := stringreplaceall (text,'O',chr(241));
      text := stringreplaceall (text,'o',chr(151));
      text := stringreplaceall (text,'O',chr(238));
      text := stringreplaceall (text,'O' ,chr(239));
      text := stringreplaceall (text,'o' ,chr(153));
      text := stringreplaceall (text,'o',chr(191));
      text := stringreplaceall (text,'O',chr(175));
      text := stringreplaceall (text,'o',chr(155));
      text := stringreplaceall (text,'O',chr(239));
      text := stringreplaceall (text,'o',chr(154));
      text := stringreplaceall (text,'O',chr(133));
      text := stringreplaceall (text,'u',chr(159));
      text := stringreplaceall (text,'U',chr(134));
      text := stringreplaceall (text,'u',chr(156));
      text := stringreplaceall (text,'U',chr(242));
      text := stringreplaceall (text,'u' ,chr(158));
      text := stringreplaceall (text,'U' ,chr(243));
      text := stringreplaceall (text,'U',chr(244));
      text := stringreplaceall (text,'u',chr(157));
      text := stringreplaceall (text,'y','y');
      text := stringreplaceall (text,'y' ,chr(216));
      text := stringreplaceall (text,'Y' ,chr(217));
      text := stringreplaceall (text,' ',' ');
      text := stringreplaceall (text,'&',chr(38));
      result := text;
    end;
     
    function sgml2rtf(text : string) : string;
    {Funktion for att byta ut sgml-entiteter mot de koder som
    galler i RTF-textrutorna.}
    begin
      text := stringreplaceall (text,'}','#]#');
      text := stringreplaceall (text,'{','#[#');
      text := stringreplaceall (text,'\','HSALSKCAB');
      text := stringreplaceall (text,'HSALSKCAB','\\');
      text := stringreplaceall (text,'?','\'+chr(39)+'c6');
      text := stringreplaceall (text,'&Aelig;','\'+chr(39)+'e6');
      text := stringreplaceall (text,'a','\'+chr(39)+'e1');
      text := stringreplaceall (text,'A','\'+chr(39)+'c1');
      text := stringreplaceall (text,'a','\'+chr(39)+'e0');
      text := stringreplaceall (text,'A','\'+chr(39)+'c0');
      text := stringreplaceall (text,'a','\'+chr(39)+'e5');
      text := stringreplaceall (text,'A','\'+chr(39)+'c5');
      text := stringreplaceall (text,'A','\'+chr(39)+'c2');
      text := stringreplaceall (text,'a','\'+chr(39)+'e2');
      text := stringreplaceall (text,'a','\'+chr(39)+'e3');
      text := stringreplaceall (text,'A','\'+chr(39)+'c3');
      text := stringreplaceall (text,'a','\'+chr(39)+'e4');
      text := stringreplaceall (text,'A','\'+chr(39)+'c4');
      text := stringreplaceall (text,'c','\'+chr(39)+'e7');
      text := stringreplaceall (text,'C','\'+chr(39)+'c7');
      text := stringreplaceall (text,'e','\'+chr(39)+'e9');
      text := stringreplaceall (text,'E','\'+chr(39)+'c9');
      text := stringreplaceall (text,'e','\'+chr(39)+'e8');
      text := stringreplaceall (text,'E','\'+chr(39)+'c8');
      text := stringreplaceall (text,'e','\'+chr(39)+'ea');
      text := stringreplaceall (text,'E','\'+chr(39)+'ca');
      text := stringreplaceall (text,'e','\'+chr(39)+'eb');
      text := stringreplaceall (text,'E','\'+chr(39)+'cb');
      text := stringreplaceall (text,'i','\'+chr(39)+'ee');
      text := stringreplaceall (text,'I','\'+chr(39)+'ce');
      text := stringreplaceall (text,'i','\'+chr(39)+'ed');
      text := stringreplaceall (text,'I','\'+chr(39)+'cd');
      text := stringreplaceall (text,'i','\'+chr(39)+'ec');
      text := stringreplaceall (text,'I','\'+chr(39)+'cc');
      text := stringreplaceall (text,'i' ,'\'+chr(39)+'ef');
      text := stringreplaceall (text,'I' ,'\'+chr(39)+'cf');
      text := stringreplaceall (text,'n','\'+chr(39)+'f1');
      text := stringreplaceall (text,'N','\'+chr(39)+'d1');
      text := stringreplaceall (text,'o','\'+chr(39)+'f6');
      text := stringreplaceall (text,'O','\'+chr(39)+'d6');
      text := stringreplaceall (text,'o','\'+chr(39)+'f3');
      text := stringreplaceall (text,'O','\'+chr(39)+'d3');
      text := stringreplaceall (text,'o','\'+chr(39)+'f2');
      text := stringreplaceall (text,'O','\'+chr(39)+'d2');
      text := stringreplaceall (text,'o','\'+chr(39)+'f8');
      text := stringreplaceall (text,'O','\'+chr(39)+'d8');
      text := stringreplaceall (text,'O','\'+chr(39)+'d4');
      text := stringreplaceall (text,'o','\'+chr(39)+'f4');
      text := stringreplaceall (text,'o','\'+chr(39)+'f5');
      text := stringreplaceall (text,'O','\'+chr(39)+'d5');
      text := stringreplaceall (text,'u','\'+chr(39)+'fa');
      text := stringreplaceall (text,'U','\'+chr(39)+'da');
      text := stringreplaceall (text,'u','\'+chr(39)+'fb');
      text := stringreplaceall (text,'U','\'+chr(39)+'db');
      text := stringreplaceall (text,'U','\'+chr(39)+'d9');
      text := stringreplaceall (text,'u','\'+chr(39)+'f9');
      text := stringreplaceall (text,'u','\'+chr(39)+'fc');
      text := stringreplaceall (text,'U','\'+chr(39)+'dc');
      text := stringreplaceall (text,'y','\'+chr(39)+'fd');
      text := stringreplaceall (text,'Y','\'+chr(39)+'dd');
      text := stringreplaceall (text,'y','\'+chr(39)+'ff');
      text := stringreplaceall (text,'?','\'+chr(39)+'a3');
      text := stringreplaceall (text,'#]#','\}');
      text := stringreplaceall (text,'#[#','\{');
      text := stringreplaceall (text,' ','|');
      text := stringreplaceall (text,'&','&');
      result := text;
    end;
     
    function rtf2sgml (text : string) : string;
    {Funktion for att konvertera en RTF-rad till SGML-text.}
    var
      temptext : string;
      start : integer;
    begin
      text := stringreplaceall (text,'&','##amp;');
      text := stringreplaceall (text,'##amp','&');
      text := stringreplaceall (text,'\'+chr(39)+'c6','?');
      text := stringreplaceall (text,'\'+chr(39)+'e6','&Aelig;');
      text := stringreplaceall (text,'\'+chr(39)+'e5','a');
      text := stringreplaceall (text,'\'+chr(39)+'c5','A');
      text := stringreplaceall (text,'\'+chr(39)+'e4','a');
      text := stringreplaceall (text,'\'+chr(39)+'c4','A');
      text := stringreplaceall (text,'\'+chr(39)+'e1','a');
      text := stringreplaceall (text,'\'+chr(39)+'c1','A');
      text := stringreplaceall (text,'\'+chr(39)+'e0','a');
      text := stringreplaceall (text,'\'+chr(39)+'c0','A');
      text := stringreplaceall (text,'\'+chr(39)+'c2','A');
      text := stringreplaceall (text,'\'+chr(39)+'e2','a');
      text := stringreplaceall (text,'\'+chr(39)+'e3','a');
      text := stringreplaceall (text,'\'+chr(39)+'c3','A');
      text := stringreplaceall (text,'\'+chr(39)+'e7','c');
      text := stringreplaceall (text,'\'+chr(39)+'c7','C');
      text := stringreplaceall (text,'\'+chr(39)+'e9','e');
      text := stringreplaceall (text,'\'+chr(39)+'c9','E');
      text := stringreplaceall (text,'\'+chr(39)+'e8','e');
      text := stringreplaceall (text,'\'+chr(39)+'c8','E');
      text := stringreplaceall (text,'\'+chr(39)+'ea','e');
      text := stringreplaceall (text,'\'+chr(39)+'ca','E');
      text := stringreplaceall (text,'\'+chr(39)+'eb','e');
      text := stringreplaceall (text,'\'+chr(39)+'cb','E');
      text := stringreplaceall (text,'\'+chr(39)+'ee','i');
      text := stringreplaceall (text,'\'+chr(39)+'ce','I');
      text := stringreplaceall (text,'\'+chr(39)+'ed','i');
      text := stringreplaceall (text,'\'+chr(39)+'cd','I');
      text := stringreplaceall (text,'\'+chr(39)+'ec','i');
      text := stringreplaceall (text,'\'+chr(39)+'cc','I');
      text := stringreplaceall (text,'\'+chr(39)+'ef','i');
      text := stringreplaceall (text,'\'+chr(39)+'cf','I');
      text := stringreplaceall (text,'\'+chr(39)+'f1','n');
      text := stringreplaceall (text,'\'+chr(39)+'d1','N');
      text := stringreplaceall (text,'\'+chr(39)+'f3','o');
      text := stringreplaceall (text,'\'+chr(39)+'d3','O');
      text := stringreplaceall (text,'\'+chr(39)+'f2','o');
      text := stringreplaceall (text,'\'+chr(39)+'d2','O');
      text := stringreplaceall (text,'\'+chr(39)+'d4','O');
      text := stringreplaceall (text,'\'+chr(39)+'f4','o');
      text := stringreplaceall (text,'\'+chr(39)+'f5','o');
      text := stringreplaceall (text,'\'+chr(39)+'d5','O');
      text := stringreplaceall (text,'\'+chr(39)+'f8','o');
      text := stringreplaceall (text,'\'+chr(39)+'d8','O');
      text := stringreplaceall (text,'\'+chr(39)+'f6','o');
      text := stringreplaceall (text,'\'+chr(39)+'d6','O');
      text := stringreplaceall (text,'\'+chr(39)+'fc','u');
      text := stringreplaceall (text,'\'+chr(39)+'dc','U');
      text := stringreplaceall (text,'\'+chr(39)+'fa','u');
      text := stringreplaceall (text,'\'+chr(39)+'da','U');
      text := stringreplaceall (text,'\'+chr(39)+'fb','u');
      text := stringreplaceall (text,'\'+chr(39)+'db','U');
      text := stringreplaceall (text,'\'+chr(39)+'d9','U');
      text := stringreplaceall (text,'\'+chr(39)+'f9','u');
      text := stringreplaceall (text,'\'+chr(39)+'fd','y');
      text := stringreplaceall (text,'\'+chr(39)+'dd','Y');
      text := stringreplaceall (text,'\'+chr(39)+'ff','y');
      text := stringreplaceall (text,'|',' ');
      text := stringreplaceall (text,'\'+chr(39)+'a3','?');
      text := stringreplaceall (text,'\}','#]#');
      text := stringreplaceall (text,'\{','#[#');
      if (beginswith (text, '{\rtf1\')) or
      (beginswith (text, '{\colortbl\')) then
      begin
        result := '';
        exit;
      end;
      //text := stringreplaceall (text,'{\fonttbl',''); {Skall alltid tas bort}
      //temptext := hamtastreng (text,'{\rtf1','{\f0');{Skall alltid tas bort}
      //text := stringreplace (text,temptext,'');
      //temptext := hamtastreng (text,'{\f0','{\f1');{Skall alltid tas bort}
      //text := stringreplace (text,temptext,'');
      //temptext := hamtastreng (text,'{\f1','{\f2');{Skall alltid tas bort}
      //text := stringreplace (text,temptext,'');
      //text := stringreplaceall (text,'{\f2\fswiss\fprq2 System;}}','');{Skall alltid tas bort}
      //text := stringreplaceall (text,'{\colortbl\red0\green0\blue0;}','');{Skall alltid tas bort}
      {I version 2.01 av Delphi finns inte \cf0 med i RTF-rutan. Tog darfor bort
      det efter \fs16 och la istallet en egen tvatt av \cf0.}
      //temptext := hamtastreng (text,'{\rtf1','\deflang');
      //text := stringreplace (text,temptext,''); {Hamta och radera allt fran start till deflang}
      text := stringreplaceall (text,'\cf0','');
      temptext := hamtastreng (text,'\deflang','\pard');{Plocka fran deflang till pard for att fa }
      text := stringreplace (text,temptext,'');{oavsett vilken lang det ar. Norska o svenska ar olika}
      text := stringreplaceall (text,'\ltrpar','');
      text := stringreplaceall (text,'\ql','');
      text := stringreplaceall (text,'\ltrch','');
      {Har skall vi plocka bort fs och flera olika siffror beroende pa vilka alternativ vi godkanner.}
      //text := stringreplaceall (text,'\fs16','');{8 punkter}
      //text := stringreplaceall (text,'\fs20','');{10 punkter}
      {Nu stadar vi istallet bort alla tvasiffriga fontsize.}
      while pos ('\fs',text)  > 0 do
      begin
        //application.processmessages;
        start := pos ('\fs',text);
        Delete(text,start,5);
      end;
      while pos ('\f',text)  > 0 do
      begin
        //application.processmessages;
        start := pos ('\f',text);
        Delete(text,start,3);
      end;
      text := stringreplaceall (text,'\pard\li200-200{\*\pn\pnlvlblt\pnf1\pnindent200{\pntxtb\'+chr(39)+'b7}}\plain ',' < /P >  < UL > ');
      text := stringreplaceall (text,'{\pntext\'+chr(39)+'b7\tab}',' < LI > ');
      text := stringreplaceall (text, '\par  < LI > ',' < LI > ');
      text := stringreplaceall (text, '\par  < UL > ',' < UL > ');
      text := stringreplaceall (text,'\pard\plain ',' < P > ');
      text := stringreplaceall (text,'\par \plain\b\ul ',' < /P >  < MELLIS > ');
      text := stringreplaceall (text,'\plain\b\ul ',' < /P >  < MELLIS > ');
      text := stringreplaceall (text,'\plain',' < /MELLIS > ');
      text := stringreplaceall (text,'\par }',' < /P > ');
      if (pos ('\par \tab ',text) > 0) or (pos (' < P > \tab ',text) > 0) then
      begin
        text := stringreplaceall (text,'\par \tab ',' < TR >  < TD > ');
        text := stringreplaceall (text,' < P > \tab ',' < TR >  < TD > ');
        text := stringreplaceall (text,'\tab ',' < /TD >  < TD > ');
      end
      else
        text := stringreplaceall (text,'\tab ','');
      text := stringreplaceall (text,'\par ',' < /P >  < P > ');
      text := stringreplaceall (text,'#]#','}');
      text := stringreplaceall (text,'#[#','{');
      text := stringreplaceall (text,'\\','\');
      if pos(' < TD > ',text) > 0 then
        text := text+' < /TD >  < /TR > ';
      if pos(' < LI > ',text) > 0 then
        text := text+' < /LI > ';
      result := text;
    end;
     
    end.
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
