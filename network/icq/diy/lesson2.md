---
Title: Урок №2
Author: Alexander Vaga, alexander_vaga@hotmail.com
Date: 22.05.2002
Source: <https://delphiworld.narod.ru>
---


Урок №2
==============================

статья: [ICQ2000 - сделай сам](./)

<table>
<tr>
<td style="border:0;width:50%;">
![](icq.jpg)
</td>
<td style="border:0;">
_Разговор по аське:  
- Что замолчал?  
- Пальцы устали._
</td>
</tr>
</table>




### Передача сообщений

Уверен, что у вас не возникло никаких проблем со скачиванием, с
компиляцией, с "конфигурированием" первого проекта. Если вы вписывали
в файл nICQ.ini свой пароль, то коннект был обеспечен.

Урок №2 содержит два новых модуля. [SendMess](sendmess_pas/) и
[MessFrom](messform_pas/). Каждый из них имеет свое окно.
Это - передача и прием сообщений.

Чтобы полноценно передавать сообщения, необходим и такой объект в
основном окне, как список контактов. Объект TTreeView напрашивается сам.
Проще некуда. Тем более каждый элемент в нем может содержать указатель
на связанные данные. TTreeView меня полностью устроил.

Сам список контактов будет хранится в файле \<ваш\_uin\>.dat

Т.к. сейчас рассматривается только урок №2, то и заполняться этот файл
будет пока только вручную. При его заполнении вполне можно пренебречь
процедурой авторизации.

    [ContactList]
    199111222=1st_User
    199111333=2nd_User
    199111444=3rd_User
    345345234=Иван Иваныч
    188888888=Вася Пупкин
    и т.д. и т.п.

Вписывайте UINов столько, сколько нужно. Только не забудьте увеличить
массив TContactList, если UINов планируете больше сотни:

    type TContactList = array[0..100] of TListRecord;

И еще пару слов относительно интерфейса: те, кому надоели зелененькие
цветочки - могут нарисовать свои значки для контактного списка. Bitmapы
прилагаются.

**Теперь о том как реально передаются сообщения.**

Есть два типа передаваемых сообщений: Simple Message и Advanced Message.

Если UIN (для которого предназначено сообщение) находится в оффлайне -
то ему шлется Simple Message. Advanced Message посылаются тем адресатам,
(кажется ) если версия аськи у них не ниже ICQ2000. Из формата Advanced
Message в уроке №2 используется лишь информация о Foreground Color и
Background Color (это цвета раскраски текста). Использовал бы еще
что-нибудь, так там больше ничего нет такого, что можно назвать
advanced.

При передаче, сообщения пакуются в SNAC(4,06).

Начнем с более простого формата - Simple Message:

FLAP                                  ||
--------------------------------------|----------
Command Start                         |2A
Channel ID                            |02
Sequence Number                       |34 3B
Data Field Length                     |00 3D
**SNAC (4, 06) - Send Message (Simple)** ||
Family ID                             |00 04 
SubType ID                            |00 06 
Flags[0]                              |00
Flags[1]                              |00
Request ID                            |00 AD 00 06
Cookie 1                              |53 DE 53 75
Cookie 2                              |16 14 BB 50
msg-format: Simple Message            |00 01
длина его UINа (почти как PascalStr)  |09
его UIN (например: "199777666")       |31 39 39 37 37 37 36 36 36
**TLV (2) - сообщение здесь**         ||
T ype                                 |00 02 
L ength                               |00 17 
V alue                                |05 01 00 01 01 01 01 (unk) ???
длина сообщения                       |00 0E
+ 4 байта                             |00 00 00 00 (unk) ??? 
Текст сообщения                       |D1 EE EE E1 F9 E5 ED E8 E5 21<br>"Сообщение!" 
**TLV (6) - пустой**                  ||
T ype                                 |00 06 
L ength                               |00 00

Продолжим более сложным форматом - Advanced Message.
А он действительно по-сложнее будет.

<table>
<tr>
  <th colspan="2">FLAP </th>
</tr>
<tr>
  <td width="25%">Command Start</td>
  <td>2A</td>
</tr>
<tr>
  <td>Channel ID</td>
  <td>02</td>
</tr>
<tr>
  <td>Sequence Number</td>
  <td>0C A3</td>
</tr>
<tr>
  <td>Data Field Length</td>
  <td>00 99</td>
</tr>
<tr>
  <td colspan="2">
    <table align="center">
      <tr>
        <th colspan="3"> SNAC (4, 06) - Send Message (Advanced)</th>
      </tr>
      <tr>
        <td width="25%">Family ID</td>
        <td colspan="2"><b> 00 04 </b></td>
      </tr>
      <tr>
        <td>SubType ID</td>
        <td colspan="2"><b> 00 06 </b></td>
      </tr>
      <tr>
        <td>Flags[0]</td>
        <td colspan="2">00</td>
      </tr>
      <tr>
        <td>Flags[1]</td>
        <td colspan="2">00</td>
      </tr>
      <tr>
        <td>Request ID</td>
        <td colspan="2">00 C3 00 06</td>
      </tr>
      <tr>
        <td>Cookie 1</td>
        <td colspan="2">1C D3 C4 B7</td>
      </tr>
      <tr>
        <td>Cookie 2</td>
        <td colspan="2">23 4D 75 95</td>
      </tr>
      <tr>
        <td> msg-format:</td>
        <td><b> 00 02 </b></td>
        <td><b>Advanced Message</b></td>
      </tr>
      <tr>
        <td>длина его UINа</td>
        <td>09</td>
        <td rowspan="2">(почти как PascalStr)</td>
      </tr>
      <tr>
        <td><b>его UIN</b><br>(например: "199777666")</td>
        <td>31 39 39<br>37 37 37<br>36 36 36</td>
      </tr>
      <tr>
        <td colspan="3">
          <br>
          <table>
          <tr>
            <th colspan="3"> TLV (5) </th>
          </tr>
          <tr>
            <td nowrap="" width="20%"><b> T </b>ype</td>
            <td colspan="2"><b> 00 05 </b></td>
          </tr>
          <tr>
            <td nowrap=""><b> L </b>ength</td>
            <td colspan="2">00 73</td>
          </tr>
          <tr>
            <td rowspan="5" nowrap=""><b> V </b>alue</td>
            <td>00 00</td>
            <td>00 00 - для посылки сообщения</td>
          </tr>
          <tr>
            <td>1C D3 C4 B7</td>
            <td>Cookie 1</td>
          </tr>
          <tr>
            <td>23 4D 75 95</td>
            <td>Cookie 2</td>
          </tr>
          <tr>
            <td>09 46 13 49<br>4C 7F 11 D1<br>82 22 44 45<br>53 54 00 00</td>
            <td>4 DWORD<br>наши возможности ???<br>(capability)</td>
          </tr>
          <tr>
            <td colspan="2">
              <table>
              <tr>
                <th colspan="3"> TLV (A) </th>
              </tr>
              <tr>
                <td nowrap="" width="25%"><b> T </b>ype</td>
                <td colspan="2"><b> 00 0A </b></td>
              </tr>
              <tr>
                <td nowrap=""><b> L </b>ength</td>
                <td colspan="2">00 02</td>
              </tr>
              <tr>
                <td nowrap=""><b> V </b>alue</td>
                <td>00 01</td>
                <td>00 01 - для посылки сообщения</td>
              </tr>
              </table>
              <br>
              <table align="center">
              <tr>
                <th colspan="3"> TLV (F) - пустой (???) </th>
              </tr>
              <tr>
                <td nowrap="" width="25%"><b> T </b>ype</td>
                <td colspan="2"><b> 00 0F </b></td>
              </tr>
              <tr>
                <td nowrap=""><b> L </b>ength</td>
                <td colspan="2">00 00</td>
              </tr>
              </table>
              <br>
              <table align="center">
              <tr>
                <th colspan="4"> TLV (2711) - сообщение здесь </th>
              </tr>
              <tr>
                <td nowrap="" width="25%"><b> T </b>ype</td>
                <td colspan="3"><b> 27 11 </b></td>
              </tr>
              <tr>
                <td nowrap=""><b> L </b>ength</td>
                <td colspan="3">00 4B</td>
              </tr>
              <tr>
                <td rowspan="14" nowrap=""><b> V </b>alue</td>
                <td>1B 00 07 00 00<br>
                    00 00 00 00 00<br>
                    00 00 00 00 00<br>
                    00 00 00 00 00<br>
                    00 00 03 00 00<br>
                    00
                </td>
                <td colspan="2">26 байт (unk)</td>
              </tr>
              <tr>
                <td>00</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td>FF FF</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td>0E 00</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td>FF FF</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td>00 00 00 00 00<br>
                    00 00 00 00 00<br>
                    00 00
                </td>
                <td colspan="2">12 байт (unk)</td>
              </tr>
              <tr>
                <td><b> 01 </b></td>
                <td colspan="2">msg-subtype (01-обычное)</td>
              </tr>
              <tr>
                <td>00</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td>00 00</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td>01 00</td>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td> 0E 00 </td>
                <td> длина сообщения </td>
                <td rowspan="2">тело сообщения (почти как PascalStr)</td>
              </tr>
              <tr>
                <td><b> D1 EE EE E1 F9 E5 ED E8 E5 20 B9 32 2E (00) </b></td>
                <td><b> 'Сообщение №2.' </b></td>
              </tr>
              <tr>
                <td>80 00 80 00</td>
                <td colspan="2">foreground color</td>
              </tr>
              <tr>
                <td>FF FF 00 00</td>
                <td colspan="2">background color</td>
              </tr>
              </table>
            </td>
          </tr>
          </table>
          <br>
          <table align="center">
          <tr>
            <th colspan="3"> TLV (3) - пустой </th>
          </tr>
          <tr>
            <td width="25%"><b> T </b>ype</td>
            <td colspan="2"><b> 00 03 </b></td>
          </tr>
          <tr>
            <td><b> L </b>ength</td>
            <td>00 00</td>
            <td>TLV(3) ( посылается, как запрос подтверждения )</td>
          </tr>
          </table>
        </td>
      </tr>
      </table>
    </td>
  </tr>
  </table>
  </td>
</tr>
</table>


Что касается кода, то мудровать с формированием TLV я не стал. Зато
получилось дешево и сердито. Одним словом - это все работает.

    unit SendMess; 
     
    procedure TMessageTo.SendButtonClick(Sender: TObject);
    var sNN,sMess,sUIN : string;
        tmp : PPack;
        sTmp : string;
        d1,d2 : longint;
        buf : TByteArray;
        ind,indmem : word;
    const capab : string{16}= #$09#$46#$13#$49#$4C#$7F#$11#$D1+
                              #$82#$22#$44#$45#$53#$54#$00#$00;
          blok : string{26} = #$1B#$00#$07#$00#$00#$00#$00#$00+
                              #$00#$00#$00#$00#$00#$00#$00#$00+
                              #$00#$00#$00#$00#$00#$00#$03#$00+
                              #$00#$00;
         x:word=0;
    begin
         sNN := NNEd.Text;
         sUIN := ICQEd.Text;
         if SendMemo.Lines.Count = 0 then exit;
         sMess := SendMemo.Text;
     
         // создаем новый FLAP
         tmp := CreatePacket(2,SEQ);
         // добавляем SNAC(4,6)
         SNACAppend(tmp,$4,$6);
         // генерируем Cookie-1 и Cookie-2
         d1:=random($7FFFFFFF);
         d2:=random($7FFFFFFF);
         // запоминаем их: по ним мы узнаем ACKи от сервера и клиента
         SEQ1:=dswap(d1);
         SEQ2:=dswap(d2);
         PacketAppend32(tmp,dswap(d1));
         PacketAppend32(tmp,dswap(d2));
     
         // проверяем какой тип сообщения выбран
         case MesFmtBox.Checked of
         true:
          begin
            // advanced message
            // 0002 - advanced
            PacketAppend16(tmp,swap($0002));
            // кому ?
            // дальше, вся последовательность формируется
            // в дополнительном буфере buf
            PacketAppendB_String(tmp,sUIN);
            // TLV(5) + его длина, которую впишем в конце
            ind:=0;fillchar(buf,sizeof(buf),'^');
            PLONG(@(buf[ind]))^:=dswap($0005FFFF);inc(ind,4);
            // Cookie-1 и Cookie-2
            PWORD(@(buf[ind]))^:=0;inc(ind,2);
            PLONG(@(buf[ind]))^:=dswap(d1);inc(ind,4);
            PLONG(@(buf[ind]))^:=dswap(d2);inc(ind,4);
            // Capability
            MOVE(capab[1],buf[ind],length(capab));inc(ind,length(capab));
            //TLV(A)=0001
            PLONG(@(buf[ind]))^:=dswap($000A0002);inc(ind,4);
            PWORD(@(buf[ind]))^:=swap($0001);inc(ind,2);
            //TLV(F)-пустой
            PLONG(@(buf[ind]))^:=dswap($000F0000);inc(ind,4);
     
            // TLV(2711) + его длина, которую впишем в конце
            PLONG(@(buf[ind]))^:=dswap($2711FFFF);inc(ind,4);
            indmem:=ind-2;
            // 16 байт
            MOVE(blok[1],buf[ind],length(blok));inc(ind,length(blok));
            PBYTE(@(buf[ind]))^:=0;inc(ind,1);
            PWORD(@(buf[ind]))^:=swap($FFFF);inc(ind,2);
            PWORD(@(buf[ind]))^:=swap($0E00);inc(ind,2);
            PWORD(@(buf[ind]))^:=swap($FFFF);inc(ind,2);
            // 12 байт = 0
            PLONG(@(buf[ind]))^:=$00000000;inc(ind,4);
            PLONG(@(buf[ind]))^:=$00000000;inc(ind,4);
            PLONG(@(buf[ind]))^:=$00000000;inc(ind,4);
            // под-Тип сообщения = 1 (обычное)
            PBYTE(@(buf[ind]))^:=1;inc(ind,1);
     
            PBYTE(@(buf[ind]))^:=0;inc(ind,1);
            PWORD(@(buf[ind]))^:=swap($0000);inc(ind,2);
            PWORD(@(buf[ind]))^:=swap($0100);inc(ind,2);
            // длина сообщения
            PWORD(@(buf[ind]))^:=length(sMess)+1;inc(ind,2);
            // сообщение
            move(sMess[1],buf[ind],length(sMess));inc(ind,length(sMess));
            // завершающий ноль
            PBYTE(@(buf[ind]))^:=0;inc(ind,1);
            // foreground color
            PLONG(@(buf[ind]))^:=dswap(GetColor(SendMemo,FG));inc(ind,4);
            // background color
            PLONG(@(buf[ind]))^:=dswap(GetColor(SendMemo,BG));inc(ind,4);
     
            // вписываем фактическую длину в TLV(5)
            PWORD(@(buf[2]))^:=swap(ind-4);
            // подсчитывем фактическую длину TLV(2711)
            x:=length(blok)+27+length(sMess)+9;
            // ... и вписывем ее
            PWORD(@(buf[indmem]))^:=swap(x);
     
            // пепеносим данные с buf в FLAP
            PacketAppend(tmp,@buf,ind);
            // ack request ? (запрос подтверждения)
            // TLV(3)-пустой
            PacketAppend32(tmp,dswap($00030000));
          end;
     
         false:
          begin // simple message
            // 0001 - simple
            PacketAppend16(tmp,swap($0001));
            // кому ?
            PacketAppendB_String(tmp,sUIN);
            // tlv(2)
            PacketAppend16(tmp,swap(2));
            // длина tlv(2)
            PacketAppend16(tmp,swap(13+length(sMess)));
            // 7 байт
            PacketAppend32(tmp,dswap($05010001));
            PacketAppend16(tmp,swap($0101));
            PacketAppend8(tmp,$01);
            // длина сообщения + 4
            PacketAppend16(tmp,swap(4+length(sMess)));
            // 4 байта = 0
            PacketAppend32(tmp,dswap($0));
            // сообщение
            PacketAppend(tmp,@(sMess[1]),length(sMess));
            // tlv(6) - пустой
            PacketAppend16(tmp,swap($0006));
            PacketAppend16(tmp,0);
          end;
         end;
         //case
         // посылаем пакет
         Form1.PacketSend(tmp);
         M(SendMemo,'Sending...');
     
         // пишем в журнал
         case MesFmtBox.Checked of
           // A - advanced
           true:  sTmp := '[A] ';
           // S - simple
           false: sTmp := '[S] ';
         end;
         // тут и так ясно
         sTmp := '->'+sTmp+DateTimeToStr(Now)+' '+
                      sNN+' ['+sUIN+']  "'+sMess+'"';
         M(Form1.Memo,sTmp);
         Form1.LogMessage(sTmp);
     
         if MesFmtBox.Checked then begin
           // если advanced
           SendAnime.Active := true;
           SendMemo.Enabled := false;
           SendButton.Enabled := false;
           MesFmtBox.Enabled := false;
           // окно закроется только после получения
           // ACKов от сервера и от клиента (или вручную)
         end
         else
           // если simple, то окно сразу закрывается
           Close;
    end;

<br>

### Прием сообщений

Все сообщения приходят в SNAC(4,07).

У него такой же формат, как и у SNAC(4,06). Поэтому стоит сразу
комментировать код:

    unit Main.pas; 
     
    procedure TForm1.SNAC_4_7(p:PPack);
    var
        i,cnt,T,MessageFormat,SubMode,SubMode2,Empty : word;
        {myUIN,}
        hisUIN : longint;
        SubType : array[0..3] of byte;
        MessageSubType : longint absolute SubType;
        tmp,tmp2,tmp3 : PPack;
        sTemp : string;
        dTemp : TByteArray;
        typemes,
        {subtypemes,}
        unk,modifier,lenmes : word;
     
        // для SNAC(4,0B)-подтверждения принятых advanced сообщений
        d1,d2 : longint;
        ACK : TByteArray;
        ind : word;
     
        NewMsg : PMsgItem;
        FG : array[0..3] of byte;
        BG : array[0..3] of byte;
    begin
         // сохраняем Cookie-1 и Cookie-2
         d1:=PacketRead32(p);
         d2:=PacketRead32(p);
         // читаем формат сообщения
         MessageFormat := swap(PacketRead16(p));
         // от кого ?
         sTemp := PacketReadB_String(p);
     
         // Cookie-1,Cookie-2 и некоторую другую часть пакета сохраним.
         // Эти данные необходимо включить в ACK на это сообщение
         ind:=0;
         PLONG(@(ACK[ind]))^:=d1; inc(ind,4);
         PLONG(@(ACK[ind]))^:=d2; inc(ind,4);
         PWORD(@(ACK[ind]))^:=swap(MessageFormat);inc(ind,2);
         PBYTE(@(ACK[ind]))^:=length(sTemp);inc(ind,1);
         MOVE(sTemp[1],ACK[ind],length(sTemp));inc(ind,length(sTemp));
         PWORD(@(ACK[ind]))^:=swap($0003);inc(ind,2);
     
         // преобразуем его UIN из строки в longint
         try hisUIN := strtoint(sTemp); except hisUIN:=0; end;
         M(Memo,'< From: '+sTemp);
         PacketRead16(p);
         // узнаем сколько всего TLV во входящем пакете
         cnt := swap(PacketRead16(p));
         // читаем все эти TLV
         for i:=1 to cnt do
           // самый интересный - TLV(6)
           if TLVReadStr(p,sTemp)=6 then begin
             { в TLV(6) - его статус }
           end;
     
         // анализируем каждый из форматов
         case MessageFormat of
         $0001: begin
                M(Memo,'< Message-format:1 (SIMPLE)');
                // чтение TLV(2) в sTemp
                TLVReadStr(p,sTemp);
                // скопируем sTemp во временный PPack,
                // для удобства обработки
                tmp := PacketNew;
                PacketAppend(tmp,@(sTemp[1]),length(sTemp));
                PacketGoto(tmp,0);
                // обработаем его
                PacketRead16(tmp);
                PacketRead16(tmp);
                PacketRead8(tmp);
                PacketRead16(tmp);
                // добрались до длины сообщения
                lenmes := swap(PacketRead16(tmp))-4;
                PacketRead32(tmp);
                // читаем сообщение в sTemp
                PacketRead(tmp,@sTemp[1],lenmes);
                SetLength(sTemp,lenmes);
                // анализ содержания сообщения
                DoSimpleMsg(hisUIN,sTemp);
                // удалим временный PPack
                PacketDelete(tmp);
                end;
     
         $0002: begin
                M(Memo,'< Message-format:2 (ADVANCED)');
                // чтение TLV(5) в sTemp
                TLVReadStr(p,sTemp);
                // скопируем sTemp во временный PPack,
                // для удобства обработки
                tmp := PacketNew;
                PacketAppend(tmp,@(sTemp[1]),length(sTemp));
                PacketGoto(tmp,0);
                // обработаем его
                SubMode := swap(PacketRead16(tmp));
                PacketRead32(tmp);
                PacketRead32(tmp);
                PacketRead(tmp,@dTemp,16);
     
                case SubMode of
                $0000: begin
                       M(Memo,'SubMode: $0000 NORMAL');
                       TLVReadWord(tmp,SubMode2);
                       // TLV(F) - пустой
                       TLVReadWord(tmp,Empty);
                       // прием и анализ TLV(2711)
                       T := TLVReadStr(tmp,sTemp);
                       if T=$2711 then begin
                         // сохраняем кусок данных для ACKа
                         MOVE(sTemp[1],ACK[ind],47);inc(ind,47);
                         PLONG(@(ACK[ind]))^:=0; inc(ind,4);
     
                         // используем временный PPack
                         tmp2 := PacketNew;
                         PacketAppend(tmp2,@(sTemp[1]),length(sTemp));
                         PacketGoto(tmp2,0);
     
                         PacketRead(tmp2,@dTemp,26);
                         PacketRead8(tmp2);
                         PacketRead16(tmp2);
                         PacketRead16(tmp2);
                         PacketRead16(tmp2);
                         PacketRead(tmp2,@dTemp,12);
                         // читаем ТИП сообщения
                         typemes := PacketRead8(tmp2);
                         {subtypemes := }PacketRead8(tmp2);
                         unk:=swap(PacketRead16(tmp2));
                         modifier:=swap(PacketRead16(tmp2));
                         M(Memo,'Unk: $'+inttohex(unk,4));
                         M(Memo,'Modifier: $'+inttohex(modifier,4));
                         // длина сообщения
                         lenmes := PacketRead16(tmp2);
                         // анализ сообщения
                         NewMsg:=DoMsg(true,typemes,
                            lenmes,PCharArray(@(tmp2^.data[tmp2^.cursor])),
                            hisUIN,Now2DateTime);
                         // небольшая перемотка
                         PacketGoto(tmp2,(tmp2^.cursor)+lenmes);
                         // читаем Foreground и Background Colors
                         PacketRead(tmp2,@FG,4);
                         PacketRead(tmp2,@BG,4);
                         if NewMsg<>nil then begin
                           NewMsg^.FG:='$00'+inttohex(FG[2],2)+
                                             inttohex(FG[1],2)+
                                             inttohex(FG[0],2);
                           NewMsg^.BG:='$00'+inttohex(BG[2],2)+
                                             inttohex(BG[1],2)+
                                             inttohex(BG[0],2);
                         end;
                         // удаление временного PPack
                         PacketDelete(tmp2);
     
                         // дозаполнение ACK
                         PWORD(@(ACK[ind]))^:= 1; inc(ind,2);
                         PBYTE(@(ACK[ind]))^:= 0; inc(ind,1);
                         PLONG(@(ACK[ind]))^:= 0; inc(ind,4);
                         PLONG(@(ACK[ind]))^:=-1; inc(ind,4);
     
                         // посылка ACKа
                         tmp3 := CreatePacket($2,SEQ);
                         SNACAppend(tmp3,$4,$0B);
                         PacketAppend(tmp3,@ACK[0],ind);
                         PacketSend(tmp3);
                       end;
                       // Submode:$0000
                       end;
                $0001: M(Memo,'SubMode:$0001 ??? message canceled ???');
                $0002: M(Memo,'SubMode:$0002 FILE-ACK');
                // case SubMode
                end;
                PacketDelete(tmp);
                end;
     
         $0004: begin
                M(Memo,'< Message-format:4 '+
                       '(url or contacts or auth-req or userAddedYou)');
                TLVReadStr(p,sTemp);
                tmp := PacketNew;
                PacketAppend(tmp,@(sTemp[1]),length(sTemp));
                PacketGoto(tmp,0);
     
                hisUIN := PacketRead32(tmp);
                typemes := PacketRead8(tmp);
                {subtypemes := }
                PacketRead8(tmp);
     
                lenmes := PacketRead16(tmp);
                DoMsg(true,typemes,
                  lenmes,PCharArray(@(tmp^.data[tmp^.cursor])),
                  hisUIN,Now2DateTime);
     
                PacketDelete(tmp);
                end;
           else M(Memo,'< ??? SNAC 4,7; Message-format: '+s(MessageFormat));
         // case MessageFormat
         end;
    end;


Исходники Урока №2 здесь:
[icq_lesson2.zip](icq_lesson2.zip).



