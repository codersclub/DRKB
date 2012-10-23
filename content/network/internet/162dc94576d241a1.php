<h1>Работа с WinInet, демо получения HTML-кода страницы</h1>
<div class="date">01.01.2007</div>


<pre>
////////////////////////////////////////////////////////////////////////////////
//
//  Демо получения HTML кода страницы
//  Автор: Александр (Rouse_) Багель
//  © Fangorn Wizards Lab 1998 - 2003
//  19 января 2003 
 
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs, ComCtrls, Wininet, StdCtrls;
 
const
  HTTP_PORT = 80;
  CRLF = #13#10;
  Header = 'Content-Type: application/x-www-form-urlencoded' + CRLF;
 
type
  TForm1 = class(TForm)
    Button1: TButton;
    Memo1: TMemo;
    Button2: TButton;
    Memo2: TMemo;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
function DelHttp(URL: String): String;
begin
  if Pos('http://', URL) &gt; 0 then Delete(Url, 1, 7);
  Result := Copy(Url, 1, Pos('/', Url) - 1);
  if Result = '' then Result := URL + #0;
end;
 
function GetUrl(const URL: String): String;
var
  FSession, FConnect, FRequest: HINTERNET;
  FHost, FScript, SRequest: String;
  Ansi: PAnsiChar;
  Buff: array [0..1023] of Char;
  BytesRead: Cardinal;
  Res, Len: DWORD;
begin
  Result := '';
  // Небольшой парсинг
  // вытаскиваем имя хоста и параметры обращения к скрипту
  FHost := DelHttp(Url);
  FScript := Url;
  Delete(FScript, 1, Pos(FHost, FScript) + Length(FHost));
  //FScript := FHost + '/' +FScript;
 
  // Инициализируем WinInet
  FSession := InternetOpen('DMFR', INTERNET_OPEN_TYPE_PRECONFIG, nil, nil, 0);
  if not Assigned(FSession) then Exit;
  try
    // Попытка соединения с сервером
    FConnect := InternetConnect(FSession, PChar(FHost), HTTP_PORT, nil,
                                'HTTP/1.0', INTERNET_SERVICE_HTTP, 0, 0);
    if not Assigned(FConnect) then Exit;
    try
      // Подготавливаем запрос страницы
      Ansi := 'text/*';
      FRequest := HttpOpenRequest(FConnect, 'GET', PChar(FScript), 'HTTP/1.1',
                                  nil, @Ansi, INTERNET_FLAG_RELOAD, 0);
      if not Assigned(FConnect) then Exit;
      try
        // Добавляем заголовки
        if not (HttpAddRequestHeaders(FRequest, Header, Length(Header),
                                      HTTP_ADDREQ_FLAG_REPLACE or
                                      HTTP_ADDREQ_FLAG_ADD or
                                      HTTP_ADDREQ_FLAG_COALESCE_WITH_COMMA)) then Exit;
 
        // Проверяем запрос:
        Len := 0;
        Res := 0;
        SRequest := ' ';
        HttpQueryInfo(FRequest, HTTP_QUERY_RAW_HEADERS_CRLF or
          HTTP_QUERY_FLAG_REQUEST_HEADERS, @SRequest[1], Len, Res);
        if Len &gt; 0 then
        begin
          SetLength(SRequest, Len);
          HttpQueryInfo(FRequest, HTTP_QUERY_RAW_HEADERS_CRLF or
            HTTP_QUERY_FLAG_REQUEST_HEADERS, @SRequest[1], Len, Res);
        end;
        Form1.Memo2.Lines.Text := SRequest;
        // Отправляем запрос
        if not (HttpSendRequest(FRequest, nil, 0, nil, 0)) then Exit;
        // Получаем ответ 
        FillChar(Buff, SizeOf(Buff), 0);
        repeat
          Result := Result + Buff;
          FillChar(Buff, SizeOf(Buff), 0);
          InternetReadFile(FRequest, @Buff, SizeOf(Buff), BytesRead);
        until BytesRead = 0; 
      finally
        InternetCloseHandle(FRequest);
      end;
    finally
      InternetCloseHandle(FConnect);
    end;
  finally
    InternetCloseHandle(FSession);
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Memo1.Text := GetUrl('http://forum.sources.ru/index.php?showforum=14');
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  Memo1.Text := GetUrl('http://forum.sources.ru/');
end;
 
end.
</pre>
<p>&nbsp;<br>
&nbsp;<br>
Проект также доступен по адресу: http://rouse.front.ru/loadhtml.zip <br>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: Rouse_</div>
