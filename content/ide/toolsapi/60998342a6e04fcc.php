<h1>Показ свойств во время выполнения программы</h1>
<div class="date">01.01.2007</div>


<p>Я написал компонент-отладчик, выводящий в дереве все компоненты. Попробуйте этот код. Вызывайте функцию DisplayProperties как показано ниже:</p>

<pre>
DisplayProperties(Form1, {Вы можете использовать любой компонент}
  Outline1.Lines, {Допускается любой TStrings-объект}
  0); {0 - "стартовый", корневой уровень}
 
DisplayProperties(AObj: TObject; AList: TStrings; iIndentLevel: Integer);
var
  Indent: string;
  ATypeInfo: PTypeInfo;
  ATypeData: PTypeData;
  APropTypeData: PTypeData;
  APropInfo: PPropInfo;
  APropList: PPropList;
  iProp: Integer;
  iCnt: Integer;
  iCntProperties: SmallInt;
  ASecondObj: TObject;
 
procedure AddLine(sLine: string);
begin
  AList.Add(Indent + #160 + IntToStr(iProp) + ': ' + APropInfo^.Name
    + ' (' + APropInfo^.PropType^.Name + ')' + sLine);
end;
 
begin
 
  try
    Indent := GetIndentSpace(iIndentLevel);
 
    ATypeInfo := AObj.ClassInfo;
    ATypeData := GetTypeData(ATypeInfo);
    iCntProperties := ATypeData^.PropCount;
    GetMem(APropList, SizeOf(TPropInfo) * iCntProperties);
    GetPropInfos(ATypeInfo, APropList);
 
    for iProp := 0 to ATypeData^.PropCount - 1 do
      begin
        APropInfo := APropList^[iProp];
        case APropInfo^.PropType^.Kind of
          tkInteger:
            AddLine(' := ' + IntToStr(GetOrdProp(AObj, APropInfo)));
          tkChar:
            AddLine(' := ' + chr(GetOrdProp(AObj, APropInfo)));
          tkEnumeration:
            begin
              APropTypeData := GetTypeData(APropInfo^.PropType);
              if APropTypeData^.BaseType^.Name &lt;&gt; APropInfo^.PropType^.Name then
                AddLine(' := ' + IntToStr(GetOrdProp(AObj, APropInfo)))
              else
                AddLine(' := ' + APropTypeData^.NameList);
            end;
          tkFloat:
            AddLine(' := ' + FloatToStr(GetFloatProp(AObj, APropInfo)));
          tkString:
            AddLine(' := "' + GetStrProp(AObj, APropInfo) + '"');
          tkSet:
            begin
              AddLine(' := ' + IntToStr(GetOrdProp(AObj, APropInfo)));
            end;
          tkClass:
            begin
              ASecondObj := TObject(GetOrdProp(AObj, APropInfo));
              if ASecondObj = nil then
                AddLine(' := NIL')
              else
                begin
                  AddLine('');
                  DisplayProperties(ASecondObj, AList, iIndentLevel + 1);
                end;
            end;
          tkMethod:
            begin
              AddLine('');
            end;
        else
          AddLine(' := &gt;&gt;НЕИЗВЕСТНО&lt;&lt;');
        end;
      end;
  except {Выводим исключение и продолжаем дальше}
    on e: Exception do ShowMessage(e.Message);
  end;
 
  FreeMem(APropList, SizeOf(TPropInfo) * iCntProperties);
end;
 
function GetIndentSpace(iIndentLevel: Integer): string;
var iCnt: Integer;
begin
  Result := '';
  for iCnt := 0 to iIndentLevel - 1 do
    Result := Result + #9;
end;
</pre>

<p>- Thomas von Stetten</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

