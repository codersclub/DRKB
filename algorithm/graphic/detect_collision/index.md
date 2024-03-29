---
Title: Detect simple collision and transparency
Date: 01.01.2007
Author: Erwin Haantjes, DelphiApplicationDiscussion@hotmail.com
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Detect simple collision and transparency
========================================

    {
    Simple collision detection and transparency, by Erwin Haantjes
    DelphiApplicationDiscussion@hotmail.com
    --------------------------------------------------------------
     
     
    It's not uncommon that collision detection in games is one of the most called functions.
    There are several ways of doing collision detection and this article describes a method
    for 2D games using bounding boxes (rectangles).
     
    Perfect collision detection down to the pixel is of course what (theoretically) is the best.
    However, checking each pixel against each other for all objects every frame in a game
    is slow, very slow. So a simplier way is needed, this is where bounding boxes comes in.
     
    Imagine that you draw a rectangle, like a frame, around an object (the player spaceship
    for examle). Then do the same thing for all the other objects in the game. Now calculate
    if these rectangles intercept each other to determine a collision, instead of checking
    each pixels. This method is much faster, not as precise, but usually exact enough.
     
    +------------+
    |      XX    |
    |    XXXXXX  |
    |XXXXXXXXXXXX|
    |    XXXXXX+-|----------+
    |      XX  |X|XX    XXXX|
    +------------+ XX  XX   |
               |    XXXX    |
               |   XX  XX   |
               |XXXX    XXXX|
               +------------+
     
    A problem is that sometimes a collision is detected when visually it seems like the object
    didn't touch. This usually occurs when any of the objects is shaped like a sphere. To
    compensate this we use an offset when checking if the bounding boxes intercept. By making
    the bounding boxes slightly smaller than the object itself, detection usually seems accurate
    enough. As mentioned before, we sacrifice precision for speed, but this is a way to compensate
    the precision to make it "feel" more exact.
     
    Here is the function which does the real collision detection of two objects. In this example
    the player's coordinates are R1, while the enemy's coordinates are R2. You can use an
    offset for the X and Y coordinates to precize the detection (especially when you using
    shaped objects).
     
    }
     
     
     
    function CheckBoundryCollision( R1, R2 : TRect; pR : PRect = nil; OffSetY : LongInt = 0; OffSetX : LongInt = 0): boolean; {overload;}
     // Simple collision test based on rectangles.
     
    begin
       // Rectangle R1 can be the rectangle of the character (player)
       // Rectangle R2 can be the rectangle of the enemy
      if( pR <> nil ) then
       begin
        // Simple collision test based on rectangles. We use here the
        // API function IntersectRect() which returns the intersection rectangle.
        with( R1 ) do
         R1:=Rect( Left+OffSetX, Top+OffSetY, Right-(OffSetX * 2), Bottom-(OffSetY * 2));
        with( R2 ) do
         R2:=Rect( Left+OffSetX, Top+OffSetY, Right-(OffSetX * 2), Bottom-(OffSetY * 2));
     
        Result:=IntersectRect( pR^, R1, R2 );
       end
      else begin
            // Simple collision test based on rectangles. We can also use the
            // API function IntersectRect() but i believe this is much faster.
            Result:=( NOT ((R1.Bottom - (OffSetY * 2) < R2.Top + OffSetY)
              or(R1.Top + OffSetY > R2.Bottom - (OffSetY * 2))
               or( R1.Right - (OffSetX * 2) < R2.Left + OffSetX)
                or( R1.Left + OffSetX > R2.Right - (OffSetX * 2))));
           end;
    end;
     
    {
     Also you can make an overloaded function with the same name based on handles (to make it easier).
    }
     
    function CheckBoundryCollision( h1, h2 : Hwnd; pR : PRect = nil; OffSetY : LongInt = 0; OffSetX : LongInt = 0): boolean; {overload;}
    var
     R1 : TRect;
     R2 : TRect;
     
    begin
     FillChar( R1, SizeOf( R1 ), 0 );
     FillChar( R2, SizeOf( R2 ), 0 );
     
      // Note: You will get here the REAL screen coordinates.
      // It doesn't matter if a control is placed inside a panel or something.
     GetWindowRect( h1, R1 );
     GetWindowRect( h2, R2 );
     
     Result:=CheckBoundryCollision( R1, R2, pR, OffsetY, OffSetX );
    end;
     
     
    As an example, the above function may be used in a (threated timer) loop like this to check the player against multiple enemies:
     
      for i := 0 to Length( Enemies ) - 1 do
       if( CheckCollision( Player.Handle, Enemies[i].Handle, nil, 4, 4 )) then
        GameOver;
     
    {
    Bottom line is that usually it's enough if it "looks" real, and less important that
    it "is" real. It's a balance between how exact we want it, and how fast we need it to perform.
     
    I have used this methods in a simple game and it just works fine. Let's talk about transparency.
    You can use Regions to create special shaped Wincontrols. For example: A TPanel with a TImage
    on it (Panel1 and Image1). You can shape the panel to the image using the following examples:
    }
     
    function  CreateRegion( Bitmap : TBitmap; Rect : TRect; TransColor : TColor ) : hRgn;
    var
     i1, Count   : LongInt;
     x,y         : LongInt;
     c1          : Cardinal;
     c,t         : TColor;
     Msg         : TMsg;
     
    begin
     
     Result:=0;
     
     if( NOT Assigned( Bitmap )) then
      Exit;
     
     Count :=0;
     
     {if( TransColor = clAutomatic ) then
      }t:=Bitmap.Canvas.Pixels[ Rect.Left, Rect.Top ]
     {else t:=TransColor};
     
     with( Bitmap.canvas ) do
      for y := Rect.Top to Rect.Bottom do
        begin
          // Sort of the same like Application.ProcessMessages but doesn't require
          // the bulky Forms unit.
         PeekMessage( Msg, 0, 0, 0, PM_REMOVE );
     
         x:=Rect.Left;
     
         while( x <= Rect.Right ) do
          begin
           C:=Pixels[ x, y ];
     
           if( C <> t ) then
            begin
             i1 := x;
     
              while( C <> t ) do
               begin
                Inc(i1);
     
                C:=Pixels[ i1, y ];
     
                if( i1 >= Rect.Right ) then
                 Break;
               end;
     
              c1:=CreateRectRgn( x-Rect.Left,y-Rect.Top, i1-Rect.Left, (y-Rect.Top) + 1 );
     
              if( count = 0 ) then
               Result:=c1
              else begin
                    CombineRgn( Result, Result, c1, RGN_OR );
                    DeleteObject( c1 );
                   end;
     
           Inc( Count );
           x := i1;
           Continue;
          end;
     
          Inc(x);
        end;
      end;
     
     if( Count = 0 ) and ( Result > 0 ) then
      begin
       DeleteObject( Result );
       Result:=0;
      end;
    end;
     
     // Put this somewhere in your code (for example in the FormCreate event)
     begin
      Image1.Left:=0;
      Image1.Top:=0;
      Image1.AutoSize:=TRUE;
      Panel1.BevelInner:=bvNone;
      Panel1.BevelOuter:=bvNone;
      Panel1.Width:=Image1.Width;
      Panel1.Height:=Image1.Height;
     
       // Create a region of the bitmap that is inside the image and set the region for the window.
       // Note: In this example the transparent color is black. Make sure the transparent (background) color is
       //       black! To be sure that you using the right color, you can also try this: Image1.Picture.Bitmap.Pixels[ 0, 0 ]
      with( Panel1 ) do
       SetWindowRgn( Handle, CreateRegion( Image1.Picture.Bitmap, Rect( 1, 1, Width, Height ), clBlack ));
     end;
     
    {
    Note: When you move the panel it is possible that the bitmap starts to flicker. You can create an
          Message handler for the message WN_EREASEBKGND to avoid the flicker. See the help of Delphi how to
          create new components and/or message handlers if do not know. Here is an example:
     
          procedure TMyPanel.WMEraseBkgnd(var Message: TWmEraseBkgnd);
          begin
           if( csDesigning in ComponentState ) then
            inherited
           else Message.Result:=1; // Fake erase
          end;
     
     
     
    NOTE: Absolutly no warranty to this code. This is just an example. It is possible that you need to make some
    improvements to the code to give it a more proffesional behaviour.
     
    This article was aimed towards beginners wanting get into game programming, I'll hope it was helpful.
     
    Regards and good luck,
    Erwin Haantjes.
    }

