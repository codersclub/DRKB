<h1>Исправление загрузки RTF-текста через поток</h1>
<div class="date">01.01.2007</div>

Автор: Лагонский Сергей Николаевич  </p>
<p>В версии Borland Delphi 3 Client/Server я обнаружил, что при загрузке текста формата RTF методом "LoadFromStream" в компонент TRichEdit он не интерпретируется как RTF, а отображается полностью (со всеми управляющими символами). Разбираясь в исходном тексте модуля COMCTRLS.PAS (дата создания: 4 августа 1997 года, размер: 391728 байт) я нашел причину, из-за которой вышеуказанный метод не работал как надо. Ниже я привожу исходный и исправленный тексты реализации метода "TRichEditStrings.LoadFromStream" (измененные строки отмечены символом "!"): </p>
<p>1. Исходный текст</p>
<pre>
procedure TRichEditStrings.LoadFromStream(Stream: TStream);
var
  EditStream: TEditStream;
  Position: Longint;
  TextType: Longint;
  StreamInfo: TRichEditStreamInfo;
  Converter: TConversion;
begin
  StreamInfo.Stream := Stream;
  if FConverter &lt;&gt; nil then
    Converter := FConverter
  else
    Converter := RichEdit.DefaultConverter.Create;
  StreamInfo.Converter := Converter;
  try
    with EditStream do
    begin
      dwCookie := LongInt(Pointer(@StreamInfo));
      pfnCallBack := @StreamLoad;
      dwError := 0;
    end;
    Position := Stream.Position;
    if PlainText then
      TextType := SF_TEXT
    else
      TextType := SF_RTF;
    SendMessage(RichEdit.Handle, EM_STREAMIN, TextType, Longint(@EditStream));
    if (TextType = SF_RTF) and (EditStream.dwError &lt;&gt; 0) then
    begin
      Stream.Position := Position;
      ! if PlainText then
        TextType := SF_RTF
          !
        else
        TextType := SF_TEXT;
 
      SendMessage(RichEdit.Handle, EM_STREAMIN, TextType, Longint(@EditStream));
      if EditStream.dwError &lt;&gt; 0 then
        raise EOutOfResources.Create(sRichEditLoadFail);
    end;
  finally
    if FConverter = nil then
      Converter.Free;
  end;
end;
</pre>


<p>2. Текст с исправлением:</p>
<pre>
 
procedure TRichEditStrings.LoadFromStream(Stream: TStream);
var
  EditStream: TEditStream;
  Position: Longint;
  TextType: Longint;
  StreamInfo: TRichEditStreamInfo;
  Converter: TConversion;
begin
  StreamInfo.Stream := Stream;
  if FConverter &lt;&gt; nil then
    Converter := FConverter
  else
    Converter := RichEdit.DefaultConverter.Create;
  StreamInfo.Converter := Converter;
  try
    with EditStream do
    begin
      dwCookie := LongInt(Pointer(@StreamInfo));
      pfnCallBack := @StreamLoad;
      dwError := 0;
    end;
    Position := Stream.Position;
    if PlainText then
      TextType := SF_TEXT
    else
      TextType := SF_RTF;
    SendMessage(RichEdit.Handle, EM_STREAMIN, TextType, Longint(@EditStream));
    if (TextType = SF_RTF) and (EditStream.dwError &lt;&gt; 0) then
    begin
      Stream.Position := Position;
      ! if PlainText then
        TextType := SF_TEXT
          !
        else
        TextType := SF_RTF;
 
      SendMessage(RichEdit.Handle, EM_STREAMIN, TextType, Longint(@EditStream));
      if EditStream.dwError &lt;&gt; 0 then
        raise EOutOfResources.Create(sRichEditLoadFail);
    end;
  finally
    if FConverter = nil then
      Converter.Free;
  end;
end;
</pre>


