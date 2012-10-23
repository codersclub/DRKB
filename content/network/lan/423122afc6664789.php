<h1>Как определить MAC адрес NIC?</h1>
<div class="date">01.01.2007</div>


<p>Вот на что наткнулся в одном из ФАКов:</p>
<p>Вариант1:</p>
<p>From : Sergey Gazimagomedov 2:453/11.13 </p>
<p>Мне нужен был МАС адpес, так я его получал, пользуясь NetBIOS.</p>
<p>Добавляешь имя NetBIOS и посылаешь на имя станции, нужной для опpеделения(можно</p>
<p>и своей) датагpамный пакет с заполненным NCB.</p>
<p>Вот исходник моей функции для опpеделения МАС адpеса.</p>
<pre>
UCHAR MYLIBAPI GetAdapterID(char *Name,
UINT lana_num,
CARDID *ID)
{
UCHAR rc = 0;
UCHAR Status[256];
while( lstrlen(Name) - 15)
lstrcat(Name, " ");
memset(&amp;SNcb, 0, sizeof(NCB));
SNcb.ncb_command = NCBASTAT;
SNcb.ncb_buffer = (LPSTR)Status;
SNcb.ncb_length = 256;
lstrcpy(SNcb.ncb_callname, Name);
SNcb.ncb_lana_num = lana_num;
rc = Netbios( &amp;SNcb );
if(rc ==0){
memcpy(ID, Status, 6);
}
return(SNcb.ncb_cmd_cplt);
}
</pre>
<p>Это под Win32. Конечно должен быть пpотокол NetBIOS, но он в фоpточках и так</p>
<p>необходим.</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<p>Вариант2:</p>
<p>From : Alexey Grachyov </p>
<pre>
void main()
{
int iAdapters,iOpt=sizeof(iAdapters),iSize=sizeof(SOCKADDR_IPX);
SOCKET skNum;
SOCKADDR_IPX Addr;
WSADATA Wsa;
if(WSAStartup(0x0101,&amp;Wsa)) return;
if((skNum=socket(AF_IPX,SOCK_DGRAM,NSPROTO_IPX))!=INVALID_SOCKET)
{
memset(&amp;Addr,0,sizeof(Addr));
Addr.sa_family=AF_IPX;
if(bind(skNum,(SOCKADDR *)&amp;Addr,iSize)!=SOCKET_ERROR)
{
if(getsockopt(skNum,NSPROTO_IPX,IPX_MAX_ADAPTER_NUM,
(char *)&amp;iAdapters,&amp;iOpt)!=SOCKET_ERROR)
{
while(iAdapters)
{
IPX_ADDRESS_DATA Data;
memset(&amp;Data,0,sizeof(Data));
Data.adapternum=iAdapters-1;
iOpt=sizeof(Data);
if(getsockopt(skNum,NSPROTO_IPX,IPX_ADDRESS,(char
*)&amp;Data,&amp;iOpt)!=SOCKET_ERROR)
{
printf("Addr: %02X%02X%02X%02X:%02X%02X%02X%02X%02X%02X\n",
(int)Data.netnum[0],(int)Data.netnum[1],(int)Data.netnum[2],
(int)Data.netnum[3],(int)Data.netnum[4],(int)Data.netnum[5],
(int)Data.netnum[6],(int)Data.netnum[7],(int)Data.netnum[8],
(int)Data.netnum[9]);
}
iAdapters--;
}
}
}
closesocket(skNum);
}
WSACleanup();
}
</pre>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<p>Вариант3:</p>
<p>From: MSDN</p>
<pre>
typedef struct _ASTAT_
{
ADAPTER_STATUS adapt;
NAME_BUFFER NameBuff [30];
}ASTAT, * PASTAT;
ASTAT Adapter;
void main (void)
{
NCB Ncb;
UCHAR uRetCode;
char NetName[50];
memset( &amp;Ncb, 0, sizeof(Ncb) );
Ncb.ncb_command = NCBRESET;
Ncb.ncb_lana_num = 0;
uRetCode = Netbios( &amp;Ncb );
printf( "The NCBRESET return code is: 0x%x \n", uRetCode );
memset( &amp;Ncb, 0, sizeof (Ncb) );
Ncb.ncb_command = NCBASTAT;
Ncb.ncb_lana_num = 0;
strcpy( Ncb.ncb_callname, "* " );
Ncb.ncb_buffer = (char *) &amp;Adapter;
Ncb.ncb_length = sizeof(Adapter);
uRetCode = Netbios( &amp;Ncb );
printf( "The NCBASTAT return code is: 0x%x \n", uRetCode );
if ( uRetCode == 0 )
{
printf( "The Ethernet Number is: %02x%02x%02x%02x%02x%02x\n",
Adapter.adapt.adapter_address[0],
Adapter.adapt.adapter_address[1],
Adapter.adapt.adapter_address[2],
Adapter.adapt.adapter_address[3],
Adapter.adapt.adapter_address[4],
Adapter.adapt.adapter_address[5] );
}
}
</pre>

<div class="author">Автор: Garik</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<div class="author">Автор: Daniel Wischnewski</div>
<p>Для того, чтобы этот код работал, необходимо включить в проект юнит NB30. Простой вызов функции GetMACAddress возвращает адрес первого установленного сетевого адаптера.</p>
<p>Совместимость: Delphi 3.x (или выше)</p>
<p>Данный пример был составлен на основе статьи на сайте&nbsp; Borland: </p>
<p><a href="https://community.borland.com/article/0,1410,26040,00.html " target="_blank">https://community.borland.com/article/0,1410,26040,00.html </a></p>
<pre>
uses 
  NB30; 
 
function GetAdapterInfo(Lana: Char): String; 
var 
  Adapter: TAdapterStatus; 
  NCB: TNCB; 
begin 
  FillChar(NCB, SizeOf(NCB), 0); 
  NCB.ncb_command := Char(NCBRESET); 
  NCB.ncb_lana_num := Lana; 
  if Netbios(@NCB) &lt;&gt; Char(NRC_GOODRET) then 
  begin 
    Result := 'mac not found'; 
    Exit; 
  end; 
 
  FillChar(NCB, SizeOf(NCB), 0); 
  NCB.ncb_command := Char(NCBASTAT); 
  NCB.ncb_lana_num := Lana; 
  NCB.ncb_callname := '*'; 
 
  FillChar(Adapter, SizeOf(Adapter), 0); 
  NCB.ncb_buffer := @Adapter; 
  NCB.ncb_length := SizeOf(Adapter); 
  if Netbios(@NCB) &lt;&gt; Char(NRC_GOODRET) then 
  begin 
    Result := 'mac not found'; 
    Exit; 
  end; 
  Result := 
    IntToHex(Byte(Adapter.adapter_address[0]), 2) + '-' + 
    IntToHex(Byte(Adapter.adapter_address[1]), 2) + '-' + 
    IntToHex(Byte(Adapter.adapter_address[2]), 2) + '-' + 
    IntToHex(Byte(Adapter.adapter_address[3]), 2) + '-' + 
    IntToHex(Byte(Adapter.adapter_address[4]), 2) + '-' + 
    IntToHex(Byte(Adapter.adapter_address[5]), 2); 
end; 
 
function GetMACAddress: string; 
var 
  AdapterList: TLanaEnum; 
  NCB: TNCB; 
begin 
  FillChar(NCB, SizeOf(NCB), 0); 
  NCB.ncb_command := Char(NCBENUM); 
  NCB.ncb_buffer := @AdapterList; 
  NCB.ncb_length := SizeOf(AdapterList); 
  Netbios(@NCB); 
  if Byte(AdapterList.length) &gt; 0 then 
    Result := GetAdapterInfo(AdapterList.lana[0]) 
  else 
    Result := 'mac not found'; 
end; 
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

