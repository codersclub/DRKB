---
Title: RTF -> HTML
Date: 01.01.2007
---


RTF -> HTML
===========

::: {.date}
01.01.2007
:::

Приведу программу, которую я использую для преобразования содержимого
RichEdit в SGML-код. Она не формирует полный HTML-аналог, но вы сами
можете добавить необходимый RTF-код и его интерпретацию в HTML-тэги.

Код содержит интуитивно понятные комментарии и строки на шведском языке,
нецелесообразные для перевода.

    function rtf2sgml(text: string): string;
    {Funktion for att konvertera en RTF-rad till SGML-text.}
    var
      temptext: string;
      start: integer;
    begin
      text := stringreplaceall(text, '&', '##amp;');
      text := stringreplaceall(text, '##amp', '&amp');
      text := stringreplaceall(text, '\' + chr(39) + 'e5', '&aring;');
      text := stringreplaceall(text, '\' + chr(39) + 'c5', '&Aring;');
      text := stringreplaceall(text, '\' + chr(39) + 'e4', '&auml;');
      text := stringreplaceall(text, '\' + chr(39) + 'c4', '&Auml;');
      text := stringreplaceall(text, '\' + chr(39) + 'f6', '&ouml;');
      text := stringreplaceall(text, '\' + chr(39) + 'd6', '&Ouml;');
      text := stringreplaceall(text, '\' + chr(39) + 'e9', '&eacute;');
      text := stringreplaceall(text, '\' + chr(39) + 'c9', '&Eacute;');
      text := stringreplaceall(text, '\' + chr(39) + 'e1', '&aacute;');
      text := stringreplaceall(text, '\' + chr(39) + 'c1', '&Aacute;');
      text := stringreplaceall(text, '\' + chr(39) + 'e0', '&agrave;');
      text := stringreplaceall(text, '\' + chr(39) + 'c0', '&Agrave;');
      text := stringreplaceall(text, '\' + chr(39) + 'f2', '&ograve;');
      text := stringreplaceall(text, '\' + chr(39) + 'd2', '&Ograve;');
      text := stringreplaceall(text, '\' + chr(39) + 'fc', '&uuml;');
      text := stringreplaceall(text, '\' + chr(39) + 'dc', '&Uuml;');
      text := stringreplaceall(text, '\' + chr(39) + 'a3', '&#163;');
      text := stringreplaceall(text, '\}', '#]#');
      text := stringreplaceall(text, '\{', '#[#');
      text := stringreplaceall(text, '{\rtf1\ansi\deff0\deftab720', ''); {Skall alltid tas bort}
      text := stringreplaceall(text, '{\fonttbl', ''); {Skall alltid tas bort}
      text := stringreplaceall(text, '{\f0\fnil MS Sans Serif;}', ''); {Skall alltid tas bort}
      text := stringreplaceall(text, '{\f1\fnil\fcharset2 Symbol;}', ''); {Skall alltid tas bort}
      text := stringreplaceall(text, '{\f2\fswiss\fprq2 System;}}', ''); {Skall alltid tas bort}
      text := stringreplaceall(text, '{\colortbl\red0\green0\blue0;}', ''); {Skall alltid tas bort}
    {I version 2.01 av Delphi finns inte \cf0 med i RTF-rutan. Tog darfor bort
    det efter \fs16 och la istallet en egen tvatt av \cf0.}
    //temptext := hamtastreng (text,'{\rtf1','\deflang');
    //text := stringreplace (text,temptext,''); {Hamta och radera allt fran start till deflang}
      text := stringreplaceall(text, '\cf0', '');
      temptext := hamtastreng(text, '\deflang', '\pard'); {Plocka fran deflang till pard for att fa }
      text := stringreplace(text, temptext, ''); {oavsett vilken lang det ar. Norska o svenska ar olika}
    {Har skall vi plocka bort fs och flera olika siffror beroende pa vilka alternativ vi godkanner.}
    //text := stringreplaceall (text,'\fs16','');{8 punkter}
    //text := stringreplaceall (text,'\fs20','');{10 punkter}
    {Nu stadar vi istallet bort alla tvasiffriga fontsize.}
      while pos('\fs', text) > 0 do
     
        begin
          application.processmessages;
          start := pos('\fs', text);
          Delete(text, start, 5);
        end;
      text := stringreplaceall(text, '\pard\plain\f0 ', '<P>');
      text := stringreplaceall(text, '\par \plain\f0\b\ul ', '</P><MELLIS>');
      text := stringreplaceall(text, '\plain\f0\b\ul ', '</P><MELLIS>');
      text := stringreplaceall(text, '\plain\f0', '</MELLIS>');
      text := stringreplaceall(text, '\par }', '</P>');
      text := stringreplaceall(text, '\par ', '</P><P>');
      text := stringreplaceall(text, '#]#', '}');
      text := stringreplaceall(text, '#[#', '{');
      text := stringreplaceall(text, '\\', '\');
      result := text;
    end;
     
        //Нижеприведенный кусок кода вырезан из довольно большой программы, вызывающей вышеприведенную функцию.
    //Я знаю что мог бы использовать потоки вместо использования отдельного файла, но у меня не было времени для реализации этого
     
     
    utfilnamn := mditted.exepath + stringreplace(stringreplace(extractfilename(pathname), '.TTT', ''), '.ttt', '') + 'ut.RTF';
    brodtext.lines.savetofile(utfilnamn);
    temptext := '';
    assignfile(tempF, utfilnamn);
    reset(tempF);
    try
      while not eof(tempF) do
        begin
          readln(tempF, temptext2);
          temptext2 := stringreplaceall(temptext2, '\' + chr(39) + 'b6', '');
          temptext2 := rtf2sgml(temptext2);
          if temptext2 <> '' then temptext := temptext + temptext2;
          application.processmessages;
        end;
    finally
      closefile(tempF);
    end;
    deletefile(utfilnamn);
    temptext := stringreplaceall(temptext, '</MELLIS> ', '</MELLIS>');
    temptext := stringreplaceall(temptext, '</P> ', '</P>');
    temptext := stringreplaceall(temptext, '</P>' + chr(0), '</P>');
    temptext := stringreplaceall(temptext, '</MELLIS></P>', '</MELLIS>');
    temptext := stringreplaceall(temptext, '<P></P>', '');
    temptext := stringreplaceall(temptext, '</P><P></MELLIS>', '</MELLIS><P>');
    temptext := stringreplaceall(temptext, '</MELLIS>', '<#MELLIS><P>');
    temptext := stringreplaceall(temptext, '<#MELLIS>', '</MELLIS>');
    temptext := stringreplaceall(temptext, '<P><P>', '<P>');
    temptext := stringreplaceall(temptext, '<P> ', '<P>');
    temptext := stringreplaceall(temptext, '<P>-', '<P>_');
    temptext := stringreplaceall(temptext, '<P>_', '<CITAT>_');
    while pos('<CITAT>_', temptext) > 0 do
      begin
        application.processmessages;
        temptext2 := hamtastreng(temptext, '<CITAT>_', '</P>');
        temptext := stringreplace(temptext, temptext2 + '</P>', temptext2 + '</CITAT>');
        temptext := stringreplace(temptext, '<CITAT>_', '<CITAT>-');
      end;
    writeln(F, '<BRODTEXT>' + temptext + '</BRODTEXT>');

Взято из Советов по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

Сборник Kuliba
