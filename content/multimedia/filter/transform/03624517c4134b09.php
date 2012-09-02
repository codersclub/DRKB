<h1>Создание уменьшенной копии картинки</h1>
<div class="date">01.01.2007</div>


<pre>
 
unit ProjetoX_Screen;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  ExtCtrls, StdCtrls, DBCtrls;
 
type
  TFormScreen = class(TForm)
    ImgFundo: TImage;
    procedure FormCreate(Sender: TObject);
  public
    { Public declarations }
    MyRegion : HRGN;
    function BitmapToRegion(hBmp: TBitmap; TransColor: TColor): HRGN;
  end;
 
var
  FormScreen: TFormScreen;
 
implementation
 
{$R *.DFM}
{===========================molda o formato do formulЯrio no bitmap}
function TFormScreen.BitmapToRegion(hBmp: TBitmap; TransColor: TColor): HRGN;
 
const
  ALLOC_UNIT = 100;
 
var
  MemDC, DC: HDC;
  BitmapInfo: TBitmapInfo;
  hbm32, holdBmp, holdMemBmp: HBitmap;
  pbits32 : Pointer;
  bm32 : BITMAP;
  maxRects: DWORD;
  hData: HGLOBAL;
  pData: PRgnData;
  b, CR, CG, CB : Byte;
  p32: pByte;
  x, x0, y: integer;
  p: pLongInt;
  pr: PRect;
  h: HRGN;
 
begin
  Result := 0;
  if hBmp &lt;&gt; nil then
  begin
    { Cria um Device Context onde serЯ armazenado o Bitmap }
    MemDC := CreateCompatibleDC(0);
    if MemDC &lt;&gt; 0 then
    begin
     { Cria um Bitmap de 32 bits sem compressТo }
      with BitmapInfo.bmiHeader do
      begin
        biSize          := sizeof(TBitmapInfoHeader);
        biWidth         := hBmp.Width;
        biHeight        := hBmp.Height;
        biPlanes        := 1;
        biBitCount      := 32;
        biCompression   := BI_RGB;
        biSizeImage     := 0;
        biXPelsPerMeter := 0;
        biYPelsPerMeter := 0;
        biClrUsed       := 0;
        biClrImportant  := 0;
      end;
      hbm32 := CreateDIBSection(MemDC, BitmapInfo, DIB_RGB_COLORS, pbits32,0, 0);
      if hbm32 &lt;&gt; 0 then
      begin
        holdMemBmp := SelectObject(MemDC, hbm32);
        {
          Calcula quantos bytes por linha o bitmap de 32 bits ocupa.
        }
        GetObject(hbm32, SizeOf(bm32), @bm32);
        while (bm32.bmWidthBytes mod 4) &gt; 0 do
          inc(bm32.bmWidthBytes);
        DC := CreateCompatibleDC(MemDC);
        { Copia o bitmap para o Device Context }
        holdBmp := SelectObject(DC, hBmp.Handle);
        BitBlt(MemDC, 0, 0, hBmp.Width, hBmp.Height, DC, 0, 0, SRCCOPY);
        {
          Para melhor performance, serЯ utilizada a funюТo ExtCreasteRegion
          para criar o HRGN. Esta funюТo recebe uma estrutura RGNDATA.
          Cada estrutura terЯ 100 retФngulos por padrТo (ALLOC_UNIT)
        }
        maxRects := ALLOC_UNIT;
        hData := GlobalAlloc(GMEM_MOVEABLE, sizeof(TRgnDataHeader) +
           SizeOf(TRect) * maxRects);
        pData := GlobalLock(hData);
        pData^.rdh.dwSize := SizeOf(TRgnDataHeader);
        pData^.rdh.iType := RDH_RECTANGLES;
        pData^.rdh.nCount := 0;
        pData^.rdh.nRgnSize := 0;
        SetRect(pData^.rdh.rcBound, MaxInt, MaxInt, 0, 0);
        { Separa o pixel em suas cores fundamentais }
        CR := GetRValue(ColorToRGB(TransColor));
        CG := GetGValue(ColorToRGB(TransColor));
        CB := GetBValue(ColorToRGB(TransColor));
        {
          Processa os pixels bitmap de baixo para cima, jЯ que bitmaps sТo
          verticalmente invertidos.
        }
        p32 := bm32.bmBits;
        inc(PChar(p32), (bm32.bmHeight - 1) * bm32.bmWidthBytes);
        for y := 0 to hBmp.Height-1 do
        begin
          { Processa os pixels do bitmap da esquerda para a direita }
          x := -1;
          while x+1 &lt; hBmp.Width do
          begin
            inc(x);
            { Procura por uma faixa contЭnua de pixels nТo transparentes }
            x0 := x;
            p := PLongInt(p32);
            inc(PChar(p), x * SizeOf(LongInt));
            while x &lt; hBmp.Width do
            begin
              b := GetBValue(p^);
              if (b = CR) then
              begin
                b := GetGValue(p^);
                if (b = CG) then
                begin
                  b := GetRValue(p^);
                  if (b = CB) then
                    break;
                end;
              end;
              inc(PChar(p), SizeOf(LongInt));
              inc(x);
            end;
            if x &gt; x0 then
            begin
              {
                Adiciona o intervalo de pixels [(x0, y),(x, y+1)] como um novo
                retФngulo na regiТo.
              }
              if pData^.rdh.nCount &gt;= maxRects then
              begin
                GlobalUnlock(hData);
                inc(maxRects, ALLOC_UNIT);
                hData := GlobalReAlloc(hData, SizeOf(TRgnDataHeader) +
                   SizeOf(TRect) * maxRects, GMEM_MOVEABLE);
                pData := GlobalLock(hData);
                Assert(pData &lt;&gt; NIL);
              end;
              pr := @pData^.Buffer[pData^.rdh.nCount * SizeOf(TRect)];
              SetRect(pr^, x0, y, x, y+1);
              if x0 &lt; pData^.rdh.rcBound.Left then
                pData^.rdh.rcBound.Left := x0;
              if y &lt; pData^.rdh.rcBound.Top then
                pData^.rdh.rcBound.Top := y;
              if x &gt; pData^.rdh.rcBound.Right then
                pData^.rdh.rcBound.Left := x;
              if y+1 &gt; pData^.rdh.rcBound.Bottom then
                pData^.rdh.rcBound.Bottom := y+1;
              inc(pData^.rdh.nCount);
              {
               No Windows98, a funюТo ExtCreateRegion() pode falhar se o n·mero
               de retФngulos for maior que 4000. Por este motivo, a regiТo deve
               ser criada por partes com menos de 4000 retФngulos. Neste caso, foram
               padronizadas regi§es com 2000 retФngulos.
              }
              if pData^.rdh.nCount = 2000 then
              begin
                h := ExtCreateRegion(NIL, SizeOf(TRgnDataHeader) +
                   (SizeOf(TRect) * maxRects), pData^);
                Assert(h &lt;&gt; 0);
               { Combina a regiТo parcial, recЪm criada, com as anteriores }
                if Result &lt;&gt; 0 then
                begin
                  CombineRgn(Result, Result, h, RGN_OR);
                  DeleteObject(h);
                end else
                  Result := h;
                pData^.rdh.nCount := 0;
                SetRect(pData^.rdh.rcBound, MaxInt, MaxInt, 0, 0);
              end;
            end;
          end;
          Dec(PChar(p32), bm32.bmWidthBytes);
        end;
        { Cria a regiТo geral }
        h := ExtCreateRegion(NIL, SizeOf(TRgnDataHeader) +
           (SizeOf(TRect) * maxRects), pData^);
        Assert(h &lt;&gt; 0);
        if Result &lt;&gt; 0 then
        begin
          CombineRgn(Result, Result, h, RGN_OR);
          DeleteObject(h);
        end else
          Result := h;
        { Com a regiТo final completa, o bitmap de 32 bits pode ser
          removido da mem?ria, com todos os outros ponteiros que foram criados.}
        GlobalFree(hData);
        SelectObject(DC, holdBmp);
        DeleteDC(DC);
        DeleteObject(SelectObject(MemDC, holdMemBmp));
      end;
    end;
    DeleteDC(MemDC);
  end;
end;
 
procedure TFormScreen.FormCreate(Sender: TObject);
begin
 
{carregue uma imagem na TImage ImgFundo}
 
{redesenha o formulario no formato do ImgFundo}
        MyRegion := BitmapToRegion(imgFundo.Picture.Bitmap,imgFundo.Canvas.Pixels[0,0]);
        SetWindowRgn(Handle,MyRegion,True);
end;
 
 
 
 
 
 
Para os outros formulЯrios basta declarar as seguintes linhas na procedure FormCreate
 
procedure TFormXXXXXX.FormCreate(Sender: TObject);
begin
 
{carregue uma imagem na TImage ImgFundo}
 
{redesenha o formulario no formato do ImgFundo}
        FormScreen.MyRegion := FormScreen.BitmapToRegion(imgFundo.Picture.Bitmap,
          imgFundo.Canvas.Pixels[0,0]);
        SetWindowRgn(Handle,FormScreen.MyRegion,True);
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
