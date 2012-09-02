<h1>Конвертировать INI-файл в XML</h1>
<div class="date">01.01.2007</div>


<pre>
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
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
