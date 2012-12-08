---
Title: Конвертировать INI-файл в XML
Date: 01.01.2007
---


Конвертировать INI-файл в XML
=============================

::: {.date}
01.01.2007
:::

    uses XMLIntf, XMLDoc, INIFiles;
     
    procedure INI2XML(const pINIFileName: string; const pXML: IXMLNode;
      const AsAttributes: Boolean = true);
    var
      lINIFile: TIniFile;
      lSections, lItems: TStringList;
      iSections, iItems: integer;
      lNode: IXMLNode;
    begin
      lINIFile := TIniFile.Create(pINIFileName);
      try
        lSections := TStringList.Create;
        try
          lItems := TStringList.Create;
          try
     
            lINIFile.ReadSections(lSections);
     
            for iSections := 0 to pred(lSections.Count) do
            begin
              lItems.Clear;
              lINIFile.ReadSection(lSections[iSections], lItems);
              lNode := pXML.AddChild(StringReplace(lSections[iSections], ' ', '',
                [rfReplaceAll]));
              for iItems := 0 to pred(lItems.Count) do
              begin
                if AsAttributes then
                  lNode.Attributes[lItems[iItems]] :=
                    lINIFile.ReadString(lSections[iSections], lItems[iItems], '')
                else
                  lNode.AddChild(lItems[iItems]).Text :=
                    lINIFile.ReadString(lSections[iSections], lItems[iItems], '');
              end;
              lNode := nil;
            end;
     
          finally lItems.Free;
          end;
        finally lSections.Free;
        end;
      finally lINIFile.Free;
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>
