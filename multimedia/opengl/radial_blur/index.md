---
Title: OpenGL - радиальное размытие
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


OpenGL - радиальное размытие
=============================

    // К заголовку RadialBlur(For OpenGL)
    // Данный код работает правильно только, если в пректе 0 форм,
    // а сам код введен в DPR файл!
     
    program RadialBlur;
     
    uses
      Windows,
      Messages,
      OpenGL;
     
    const
      WND_TITLE = 'Radial Blur';
      FPS_TIMER = 1; // Timer to calculate FPS
      FPS_INTERVAL = 1000; // Calculate FPS every 1000 ms
     
    type
      TVector = array[0..2] of glFloat;
    var
      h_Wnd: HWND; // Global window handle
      h_DC: HDC; // Global device context
      h_RC: HGLRC; // OpenGL rendering context
      keys: array[0..255] of Boolean; // Holds keystrokes
      FPSCount: Integer = 0; // Counter for FPS
      ElapsedTime: Integer; // Elapsed time between frames
     
      // Textures
      BlurTexture: glUint; // An Unsigned Int To Store The Texture Number
     
      // User vaiables
      Angle: glFloat;
      Vertexes: array[0..3] of TVector;
      normal: TVector;
     
      // Lights and Materials
      globalAmbient: array[0..3] of glFloat = (0.2, 0.2, 0.2, 1.0);
      // Set Ambient Lighting To Fairly Dark Light (No Color)
      Light0Pos: array[0..3] of glFloat = (0.0, 5.0, 10.0, 1.0);
      // Set The Light Position
      Light0Ambient: array[0..3] of glFloat = (0.2, 0.2, 0.2, 1.0);
      // More Ambient Light
      Light0Diffuse: array[0..3] of glFloat = (0.3, 0.3, 0.3, 1.0);
      // Set The Diffuse Light A Bit Brighter
      Light0Specular: array[0..3] of glFloat = (0.8, 0.8, 0.8, 1.0);
      // Fairly Bright Specular Lighting
     
      LmodelAmbient: array[0..3] of glFloat = (0.2, 0.2, 0.2, 1.0);
      // And More Ambient Light
     
    {$R *.RES}
     
    procedure glBindTexture(target: GLenum; texture: GLuint);
      stdcall; external opengl32;
     
    procedure glGenTextures(n: GLsizei; var textures: GLuint);
      stdcall; external opengl32;
     
    procedure glCopyTexSubImage2D(target: GLenum; level, xoffset,
      yoffset, x, y: GLint; width, height: GLsizei);
      stdcall; external opengl32;
     
    procedure glCopyTexImage2D(target: GLenum; level: GLint;
      internalFormat: GLenum; x, y: GLint;
      width, height: GLsizei; border: GLint); stdcall; external opengl32;
     
    {------------------------------------------------------------------}
    { Function to convert int to string. (No sysutils = smaller EXE) }
    {------------------------------------------------------------------}
    // using SysUtils increase file size by 100K
     
    function IntToStr(Num: Integer): string;
    begin
      Str(Num, result);
    end;
     
    function EmptyTexture: glUint;
    var
      txtnumber: glUint;
      data: array of glUint;
      pData: Pointer;
    begin
      // Create Storage Space For Texture Data (128x128x4)
      GetMem(pData, 128 * 128 * 4);
     
      glGenTextures(1, txtnumber); // Create 1 Texture
      glBindTexture(GL_TEXTURE_2D, txtnumber); // Bind The Texture
      glTexImage2D(GL_TEXTURE_2D, 0, 4, 128, 128, 0, GL_RGBA,
        GL_UNSIGNED_BYTE, pData);
      glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MIN_FILTER, GL_LINEAR);
      glTexParameteri(GL_TEXTURE_2D, GL_TEXTURE_MAG_FILTER, GL_LINEAR);
     
      result := txtNumber;
    end;
     
    procedure ReduceToUnit(var vector: array of glFloat);
    var
      length: glFLoat;
    begin
      // Calculates The Length Of The Vector
      length := sqrt((vector[0] * vector[0]) + (vector[1] * vector[1]) +
        (vector[2] * vector[2]));
      if Length = 0 then
        Length := 1;
     
      vector[0] := vector[0] / length;
      vector[1] := vector[1] / length;
      vector[2] := vector[2] / length;
    end;
     
    procedure calcNormal(const v: array of TVector;
      var cross: array of glFloat);
    var
      v1, v2: array[0..2] of glFloat;
    begin
      // Finds The Vector Between 2 Points By Subtracting
      // The x,y,z Coordinates From One Point To Another.
     
      // Calculate The Vector From Point 1 To Point 0
      v1[0] := v[0][0] - v[1][0]; // Vector 1.x=Vertex[0].x-Vertex[1].x
      v1[1] := v[0][1] - v[1][1]; // Vector 1.y=Vertex[0].y-Vertex[1].y
      v1[2] := v[0][2] - v[1][2]; // Vector 1.z=Vertex[0].y-Vertex[1].z
      // Calculate The Vector From Point 2 To Point 1
      v2[0] := v[1][0] - v[2][0]; // Vector 2.x=Vertex[0].x-Vertex[1].x
      v2[1] := v[1][1] - v[2][1]; // Vector 2.y=Vertex[0].y-Vertex[1].y
      v2[2] := v[1][2] - v[2][2]; // Vector 2.z=Vertex[0].z-Vertex[1].z
      // Compute The Cross Product To Give Us A Surface Normal
      cross[0] := v1[1] * v2[2] - v1[2] * v2[1]; // Cross Product For Y - Z
      cross[1] := v1[2] * v2[0] - v1[0] * v2[2]; // Cross Product For X - Z
      cross[2] := v1[0] * v2[1] - v1[1] * v2[0]; // Cross Product For X - Y
     
      ReduceToUnit(cross); // Normalize The Vectors
    end;
     
    // Draws A Helix
     
    procedure ProcessHelix;
    const
      Twists = 5;
      MaterialColor: array[1..4] of glFloat = (0.4, 0.2, 0.8, 1.0);
      Specular: array[1..4] of glFloat = (1, 1, 1, 1);
    var
      x, y, z: glFLoat;
      phi, theta: Integer;
      r, u, v: glFLoat;
    begin
      glLoadIdentity(); // Reset The Modelview Matrix
      // Eye Position (0,5,50) Center Of Scene (0,0,0), Up On Y Axis
      gluLookAt(0, 5, 50, 0, 0, 0, 0, 1, 0);
     
      glPushMatrix(); // Push The Modelview Matrix
      glTranslatef(0, 0, -50); // Translate 50 Units Into The Screen
      glRotatef(angle / 2.0, 1, 0, 0); // Rotate By angle/2 On The X-Axis
      glRotatef(angle / 3.0, 0, 1, 0); // Rotate By angle/3 On The Y-Axis
     
      glMaterialfv(GL_FRONT_AND_BACK, GL_AMBIENT_AND_DIFFUSE, @MaterialColor);
      glMaterialfv(GL_FRONT_AND_BACK, GL_SPECULAR, @specular);
     
      r := 1.5; // Radius
     
      glBegin(GL_QUADS); // Begin Drawing Quads
      phi := 0;
      while phi < 360 do
      begin
        theta := 0;
        while theta < 360 * twists do
        begin
          v := phi / 180 * pi; // Calculate Angle Of First Point ( 0 )
          u := theta / 180.0 * pi; // Calculate Angle Of First Point ( 0 )
     
          x := cos(u) * (2 + cos(v)) * r; // Calculate x Position (1st Point)
          y := sin(u) * (2 + cos(v)) * r; // Calculate y Position (1st Point)
          z := (u - (2 * pi) + sin(v)) * r; // Calculate z Position (1st Point)
     
          vertexes[0][0] := x; // Set x Value Of First Vertex
          vertexes[0][1] := y; // Set y Value Of First Vertex
          vertexes[0][2] := z; // Set z Value Of First Vertex
     
          v := (phi / 180 * pi); // Calculate Angle Of Second Point ( 0 )
          u := ((theta + 20) / 180 * pi); // Calculate Angle Of Second Point ( 20 )
     
          x := cos(u) * (2 + cos(v)) * r; // Calculate x Position (2nd Point)
          y := sin(u) * (2 + cos(v)) * r; // Calculate y Positio
          z := (u - (2 * pi) + sin(v)) * r; // Calculate z Position (2nd Point)
     
          vertexes[1][0] := x; // Set x Value Of Second Vertex
          vertexes[1][1] := y; // Set y Value Of Second Vertex
          vertexes[1][2] := z; // Set z Value Of Second Vertex
     
          v := (phi + 20) / 180 * pi; // Calculate Angle Of Third Point ( 20 )
          u := (theta + 20) / 180 * pi; // Calculate Angle Of Third Point ( 20 )
     
          x := cos(u) * (2 + cos(v)) * r; // Calculate x Position (3rd Point)
          y := sin(u) * (2 + cos(v)) * r; // Calculate y Position (3rd Point)
          z := (u - (2 * pi) + sin(v)) * r; // Calculate z Position (3rd Point)
     
          vertexes[2][0] := x; // Set x Value Of Third Vertex
          vertexes[2][1] := y; // Set y Value Of Third Vertex
          vertexes[2][2] := z; // Set z Value Of Third Vertex
     
          v := (phi + 20) / 180 * pi; // Calculate Angle Of Fourth Point ( 20 )
          u := theta / 180 * pi; // Calculate Angle Of Fourth Point ( 0 )
     
          x := cos(u) * (2 + cos(v)) * r; // Calculate x Position (4th Point)
          y := sin(u) * (2 + cos(v)) * r; // Calculate y Position (4th Point)
          z := (u - (2 * pi) + sin(v)) * r; // Calculate z Position (4th Point)
     
          vertexes[3][0] := x; // Set x Value Of Fourth Vertex
          vertexes[3][1] := y; // Set y Value Of Fourth Vertex
          vertexes[3][2] := z; // Set z Value Of Fourth Vertex
     
          calcNormal(vertexes, normal); // Calculate The Quad Normal
     
          glNormal3f(normal[0], normal[1], normal[2]); // Set The Normal
     
          // Render The Quad
          glVertex3f(vertexes[0][0], vertexes[0][1], vertexes[0][2]);
          glVertex3f(vertexes[1][0], vertexes[1][1], vertexes[1][2]);
          glVertex3f(vertexes[2][0], vertexes[2][1], vertexes[2][2]);
          glVertex3f(vertexes[3][0], vertexes[3][1], vertexes[3][2]);
          theta := theta + 20;
        end;
        phi := phi + 20;
      end;
      glEnd(); // Done Rendering Quads
      glPopMatrix(); // Pop The Matrix
    end;
     
    // Set Up An Ortho View
     
    procedure ViewOrtho;
    begin
      glMatrixMode(GL_PROJECTION); // Select Projection
      glPushMatrix(); // Push The Matrix
      glLoadIdentity(); // Reset The Matrix
      glOrtho(0, 640, 480, 0, -1, 1); // Select Ortho Mode (640x480)
      glMatrixMode(GL_MODELVIEW); // Select Modelview Matrix
      glPushMatrix(); // Push The Matrix
      glLoadIdentity(); // Reset The Matrix
    end;
     
    // Set Up A Perspective View
     
    procedure ViewPerspective;
    begin
      glMatrixMode(GL_PROJECTION); // Select Projection
      glPopMatrix(); // Pop The Matrix
      glMatrixMode(GL_MODELVIEW); // Select Modelview
      glPopMatrix(); // Pop The Matrix
    end;
     
    // Renders To A Texture
     
    procedure RenderToTexture;
    begin
      glViewport(0, 0, 128, 128); // Set Our Viewport (Match Texture Size)
      ProcessHelix(); // Render The Helix
      glBindTexture(GL_TEXTURE_2D, BlurTexture); // Bind To The Blur Texture
     
      // Copy Our ViewPort To The Blur Texture (From 0,0 To 128,128... No Border)
      glCopyTexImage2D(GL_TEXTURE_2D, 0, GL_LUMINANCE, 0, 0, 128, 128, 0);
      glClearColor(0.0, 0.0, 0.5, 0.5); // Set The Clear Color To Medium Blue
      // Clear The Screen And Depth Buffer
      glClear(GL_COLOR_BUFFER_BIT or GL_DEPTH_BUFFER_BIT);
      glViewport(0, 0, 640, 480); // Set Viewport (0,0 to 640x480)
    end;
     
    // Draw The Blurred Image
     
    procedure DrawBlur(const times: Integer; const inc: glFloat);
    var
      spost, alpha, alphainc: glFloat;
      I: Integer;
    begin
      alpha := 0.2;
     
      glEnable(GL_TEXTURE_2D); // Enable 2D Texture Mapping
      glDisable(GL_DEPTH_TEST); // Disable Depth Testing
      glBlendFunc(GL_SRC_ALPHA, GL_ONE); // Set Blending Mode
      glEnable(GL_BLEND); // Enable Blending
      glBindTexture(GL_TEXTURE_2D, BlurTexture); // Bind To The Blur Texture
      ViewOrtho(); // Switch To An Ortho View
     
      alphainc := alpha / times; // alphainc=0.2f / Times To Render Blur
     
      glBegin(GL_QUADS); // Begin Drawing Quads
      // Number Of Times To Render Blur
      for I := 0 to times - 1 do
      begin
        glColor4f(1.0, 1.0, 1.0, alpha); // Set The Alpha Value (Starts At 0.2)
        glTexCoord2f(0 + spost, 1 - spost); // Texture Coordinate ( 0, 1 )
        glVertex2f(0, 0); // First Vertex ( 0, 0 )
     
        glTexCoord2f(0 + spost, 0 + spost); // Texture Coordinate ( 0, 0 )
        glVertex2f(0, 480); // Second Vertex ( 0, 480 )
     
        glTexCoord2f(1 - spost, 0 + spost); // Texture Coordinate ( 1, 0 )
        glVertex2f(640, 480); // Third Vertex ( 640, 480 )
     
        glTexCoord2f(1 - spost, 1 - spost); // Texture Coordinate ( 1, 1 )
        glVertex2f(640, 0); // Fourth Vertex ( 640, 0 )
     
        // Gradually Increase spost (Zooming Closer To Texture Center)
        spost := spost + inc;
        // Gradually Decrease alpha (Gradually Fading Image Out)
        alpha := alpha - alphainc;
      end;
      glEnd(); // Done Drawing Quads
     
      ViewPerspective(); // Switch To A Perspective View
     
      glEnable(GL_DEPTH_TEST); // Enable Depth Testing
      glDisable(GL_TEXTURE_2D); // Disable 2D Texture Mapping
      glDisable(GL_BLEND); // Disable Blending
      glBindTexture(GL_TEXTURE_2D, 0); // Unbind The Blur Texture
    end;
     
    {------------------------------------------------------------------}
    { Function to draw the actual scene }
    {------------------------------------------------------------------}
     
    procedure glDraw();
    begin
      // Clear The Screen And The Depth Buffer
      glClear(GL_COLOR_BUFFER_BIT or GL_DEPTH_BUFFER_BIT);
      glLoadIdentity(); // Reset The View
      RenderToTexture; // Render To A Texture
      ProcessHelix; // Draw Our Helix
      DrawBlur(25, 0.02); // Draw The Blur Effect
     
      angle := ElapsedTime / 5; // Update angle Based On The Clock
    end;
     
    {------------------------------------------------------------------}
    { Initialise OpenGL }
    {------------------------------------------------------------------}
     
    procedure glInit();
    begin
      glClearColor(0.0, 0.0, 0.0, 0.5); // Black Background
      glShadeModel(GL_SMOOTH); // Enables Smooth Color Shading
      glClearDepth(1.0); // Depth Buffer Setup
      glDepthFunc(GL_LESS); // The Type Of Depth Test To Do
     
      glHint(GL_PERSPECTIVE_CORRECTION_HINT, GL_NICEST);
      file:
      //Realy Nice perspective calculations
     
      glEnable(GL_DEPTH_TEST); // Enable Depth Buffer
      glEnable(GL_TEXTURE_2D); // Enable Texture Mapping
     
      // Set The Ambient Light Model
      glLightModelfv(GL_LIGHT_MODEL_AMBIENT, @LmodelAmbient);
     
      // Set The Global Ambient Light Model
      glLightModelfv(GL_LIGHT_MODEL_AMBIENT, @GlobalAmbient);
      glLightfv(GL_LIGHT0, GL_POSITION, @light0Pos); // Set The Lights Position
      glLightfv(GL_LIGHT0, GL_AMBIENT, @light0Ambient); // Set The Ambient Light
      glLightfv(GL_LIGHT0, GL_DIFFUSE, @light0Diffuse); // Set The Diffuse Light
      // Set Up Specular Lighting
      glLightfv(GL_LIGHT0, GL_SPECULAR, @light0Specular);
      glEnable(GL_LIGHTING); // Enable Lighting
      glEnable(GL_LIGHT0); // Enable Light0
     
      BlurTexture := EmptyTexture(); // Create Our Empty Texture
      glShadeModel(GL_SMOOTH); // Select Smooth Shading
      glMateriali(GL_FRONT, GL_SHININESS, 128);
    end;
     
    {------------------------------------------------------------------}
    { Handle window resize }
    {------------------------------------------------------------------}
     
    procedure glResizeWnd(Width, Height: Integer);
    begin
      if (Height = 0) then // prevent divide by zero exception
        Height := 1;
      glViewport(0, 0, Width, Height); // Set the viewport for the OpenGL window
      glMatrixMode(GL_PROJECTION); // Change Matrix Mode to Projection
      glLoadIdentity(); // Reset View
      gluPerspective(45.0, Width / Height, 2.0, 200.0);
      // Do the perspective calculations. Last value = max clipping depth
     
      glMatrixMode(GL_MODELVIEW); // Return to the modelview matrix
      glLoadIdentity(); // Reset View
    end;
     
    {------------------------------------------------------------------}
    { Processes all the keystrokes }
    {------------------------------------------------------------------}
     
    procedure ProcessKeys;
    begin
    end;
     
    {------------------------------------------------------------------}
    { Determines the application response to the messages received     }
    {------------------------------------------------------------------}
     
    function WndProc(hWnd: HWND; Msg: UINT; wParam: WPARAM; lParam: LPARAM):
      LRESULT; stdcall;
    begin
      case (Msg) of
        WM_CREATE:
          begin
            // Insert stuff you want executed when the program starts
          end;
        WM_CLOSE:
          begin
            PostQuitMessage(0);
            Result := 0
          end;
        // Set the pressed key (wparam) to equal true so we can check if its pressed
        WM_KEYDOWN:
          begin
            keys[wParam] := True;
            Result := 0;
          end;
        // Set the released key (wparam) to equal false so we can check if its pressed
        WM_KEYUP:
          begin
            keys[wParam] := False;
            Result := 0;
          end;
        WM_SIZE: // Resize the window with the new width and height
          begin
            glResizeWnd(LOWORD(lParam), HIWORD(lParam));
            Result := 0;
          end;
        WM_TIMER: // Add code here for all timers to be used.
          begin
            if wParam = FPS_TIMER then
            begin
              FPSCount := Round(FPSCount * 1000 / FPS_INTERVAL);
              // calculate to get per Second incase intercal is
              // less or greater than 1 second
              SetWindowText(h_Wnd, PChar(WND_TITLE + ' [' + intToStr(FPSCount)
                + ' FPS]'));
              FPSCount := 0;
              Result := 0;
            end;
          end;
      else
        // Default result if nothing happens
        Result := DefWindowProc(hWnd, Msg, wParam, lParam);
      end;
    end;
     
    {---------------------------------------------------------------------}
    { Properly destroys the window created at startup (no memory leaks) }
    {---------------------------------------------------------------------}
     
    procedure glKillWnd(Fullscreen: Boolean);
    begin
      if Fullscreen then // Change back to non fullscreen
      begin
        ChangeDisplaySettings(devmode(nil^), 0);
        ShowCursor(True);
      end;
     
      // Makes current rendering context not current, and releases the device
      // context that is used by the rendering context.
      if (not wglMakeCurrent(h_DC, 0)) then
        MessageBox(0, 'Release of DC and RC failed!', 'Error',
          MB_OK or MB_ICONERROR);
     
      // Attempts to delete the rendering context
      if (not wglDeleteContext(h_RC)) then
      begin
        MessageBox(0, 'Release of rendering context failed!', 'Error',
          MB_OK or MB_ICONERROR);
        h_RC := 0;
      end;
     
      // Attemps to release the device context
      if ((h_DC = 1) and (ReleaseDC(h_Wnd, h_DC) < > 0)) then
      begin
        MessageBox(0, 'Release of device context failed!', 'Error',
          MB_OK or MB_ICONERROR);
        h_DC := 0;
      end;
     
      // Attempts to destroy the window
      if ((h_Wnd < > 0) and (not DestroyWindow(h_Wnd))) then
      begin
        MessageBox(0, 'Unable to destroy window!', 'Error', MB_OK or
          h_Wnd := 0;
      end;
     
      // Attempts to unregister the window class
      if (not UnRegisterClass('OpenGL', hInstance)) then
      begin
        MessageBox(0, 'Unable to unregister window class!', 'Error',
          MB_OK or MB_ICONERROR);
        hInstance := 0;
      end;
    end;
     
    {--------------------------------------------------------------------}
    { Creates the window and attaches a OpenGL rendering context to it }
    {--------------------------------------------------------------------}
     
    function glCreateWnd(Width, Height: Integer; Fullscreen: Boolean;
      PixelDepth: Integer): Boolean;
    var
      wndClass: TWndClass; // Window class
      dwStyle: DWORD; // Window styles
      dwExStyle: DWORD; // Extended window styles
      dmScreenSettings: DEVMODE; // Screen settings (fullscreen, etc...)
      PixelFormat: GLuint; // Settings for the OpenGL rendering
      h_Instance: HINST; // Current instance
      pfd: TPIXELFORMATDESCRIPTOR; // Settings for the OpenGL window
    begin
      h_Instance := GetModuleHandle(nil);
      file: //Grab An Instance For Our Window
      ZeroMemory(@wndClass, SizeOf(wndClass)); // Clear the window class structure
     
      with wndClass do // Set up the window class
      begin
        style := CS_HREDRAW or // Redraws entire window if length changes
        CS_VREDRAW or // Redraws entire window if height changes
        CS_OWNDC; // Unique device context for the window
        lpfnWndProc := @WndProc; // Set the window procedure to our func WndProc
        hInstance := h_Instance;
        hCursor := LoadCursor(0, IDC_ARROW);
        lpszClassName := 'OpenGL';
      end;
     
      if (RegisterClass(wndClass) = 0) then // Attemp to register the window class
      begin
        MessageBox(0, 'Failed to register the window class!', 'Error',
          MB_OK or MB_ICONERROR);
        Result := False;
        Exit
      end;
     
      // Change to fullscreen if so desired
      if Fullscreen then
      begin
        ZeroMemory(@dmScreenSettings, SizeOf(dmScreenSettings));
        with dmScreenSettings do
        begin // Set parameters for the screen setting
          dmSize := SizeOf(dmScreenSettings);
          dmPelsWidth := Width; // Window width
          dmPelsHeight := Height; // Window height
          dmBitsPerPel := PixelDepth; // Window color depth
          dmFields := DM_PELSWIDTH or DM_PELSHEIGHT or DM_BITSPERPEL;
        end;
     
        // Try to change screen mode to fullscreen
        if (ChangeDisplaySettings(dmScreenSettings, CDS_FULLSCREEN) =
          DISP_CHANGE_FAILED) then
        begin
          MessageBox(0, 'Unable to switch to fullscreen!', 'Error',
            MB_OK or MB_ICONERROR);
          Fullscreen := False;
        end;
      end;
     
      // If we are still in fullscreen then
      if (Fullscreen) then
      begin
        dwStyle := WS_POPUP or // Creates a popup window
        WS_CLIPCHILDREN // Doesn't draw within child windows
        or WS_CLIPSIBLINGS; // Doesn't draw within sibling windows
        dwExStyle := WS_EX_APPWINDOW; // Top level window
        ShowCursor(False); // Turn of the cursor (gets in the way)
      end
      else
      begin
        dwStyle := WS_OVERLAPPEDWINDOW or // Creates an overlapping window
        WS_CLIPCHILDREN or // Doesn't draw within child windows
        WS_CLIPSIBLINGS; // Doesn't draw within sibling windows
        dwExStyle := WS_EX_APPWINDOW or // Top level window
        WS_EX_WINDOWEDGE; // Border with a raised edge
      end;
     
      // Attempt to create the actual window
      h_Wnd := CreateWindowEx(dwExStyle, // Extended window styles
        'OpenGL', // Class name
        WND_TITLE, // Window title (caption)
        dwStyle, // Window styles
        0, 0, // Window position
        Width, Height, // Size of window
        0, // No parent window
        0, // No menu
        h_Instance, // Instance
        nil); // Pass nothing to WM_CREATE
      if h_Wnd = 0 then
      begin
        glKillWnd(Fullscreen); // Undo all the settings we've changed
        MessageBox(0, 'Unable to create window!', 'Error', MB_OK or MB_ICONERROR);
        Result := False;
        Exit;
      end;
     
      // Try to get a device context
      h_DC := GetDC(h_Wnd);
      if (h_DC = 0) then
      begin
        glKillWnd(Fullscreen);
        MessageBox(0, 'Unable to get a device context!', 'Error',
          MB_OK or MB_ICONERROR);
        Result := False;
        Exit;
      end;
     
      // Settings for the OpenGL window
      with pfd do
      begin
        // Size Of This Pixel Format Descriptor
        nSize := SizeOf(TPIXELFORMATDESCRIPTOR);
        nVersion := 1; // The version of this data structure
        dwFlags := PFD_DRAW_TO_WINDOW // Buffer supports drawing to window
        or PFD_SUPPORT_OPENGL // Buffer supports OpenGL drawing
        or PFD_DOUBLEBUFFER; // Supports double buffering
        iPixelType := PFD_TYPE_RGBA; // RGBA color format
        cColorBits := PixelDepth; // OpenGL color depth
        cRedBits := 0; // Number of red bitplanes
        cRedShift := 0; // Shift count for red bitplanes
        cGreenBits := 0; // Number of green bitplanes
        cGreenShift := 0; // Shift count for green bitplanes
        cBlueBits := 0; // Number of blue bitplanes
        cBlueShift := 0; // Shift count for blue bitplanes
        cAlphaBits := 0; // Not supported
        cAlphaShift := 0; // Not supported
        cAccumBits := 0; // No accumulation buffer
        cAccumRedBits := 0; // Number of red bits in a-buffer
        cAccumGreenBits := 0; // Number of green bits in a-buffer
        cAccumBlueBits := 0; // Number of blue bits in a-buffer
        cAccumAlphaBits := 0; // Number of alpha bits in a-buffer
        cDepthBits := 16; // Specifies the depth of the depth buffer
        cStencilBits := 0; // Turn off stencil buffer
        cAuxBuffers := 0; // Not supported
        iLayerType := PFD_MAIN_PLANE; // Ignored
        bReserved := 0; // Number of overlay and underlay planes
        dwLayerMask := 0; // Ignored
        dwVisibleMask := 0; // Transparent color of underlay plane
        dwDamageMask := 0; // Ignored
      end;
     
      // Attempts to find the pixel format supported by a device context that
      // is the best match to a given pixel format specification.
      PixelFormat := ChoosePixelFormat(h_DC, @pfd);
      if (PixelFormat = 0) then
      begin
        glKillWnd(Fullscreen);
        MessageBox(0, 'Unable to find a suitable pixel format', 'Error',
          MB_OK or MB_ICONERROR);
        Result := False;
        Exit;
      end;
     
      // Sets the specified device context's pixel format to the format
      // specified by the PixelFormat.
      if (not SetPixelFormat(h_DC, PixelFormat, @pfd)) then
      begin
        glKillWnd(Fullscreen);
        MessageBox(0, 'Unable to set the pixel format', 'Error',
          MB_OK or MB_ICONERROR);
        Result := False;
        Exit;
      end;
     
      // Create a OpenGL rendering context
      h_RC := wglCreateContext(h_DC);
      if (h_RC = 0) then
      begin
        glKillWnd(Fullscreen);
        MessageBox(0, 'Unable to create an OpenGL rendering context',
          'Error', MB_OK or MB_ICONERROR);
        Result := False;
        Exit;
      end;
     
      // Makes the specified OpenGL rendering context the calling
      // thread's current rendering context
      if (not wglMakeCurrent(h_DC, h_RC)) then
      begin
        glKillWnd(Fullscreen);
        MessageBox(0, 'Unable to activate OpenGL rendering context', 'Error',
          MB_OK or MB_ICONERROR);
        Result := False;
        Exit;
      end;
     
      // Initializes the timer used to calculate the FPS
      SetTimer(h_Wnd, FPS_TIMER, FPS_INTERVAL, nil);
     
      // Settings to ensure that the window is the topmost window
      ShowWindow(h_Wnd, SW_SHOW);
      SetForegroundWindow(h_Wnd);
      SetFocus(h_Wnd);
     
      // Ensure the OpenGL window is resized properly
      glResizeWnd(Width, Height);
      glInit();
     
      Result := True;
    end;
     
    {--------------------------------------------------------------------}
    { Main message loop for the application }
    {--------------------------------------------------------------------}
     
    function WinMain(hInstance: HINST; hPrevInstance: HINST;
      lpCmdLine: PChar; nCmdShow: Integer): Integer; stdcall;
    var
      msg: TMsg;
      finished: Boolean;
      DemoStart, LastTime: DWord;
    begin
      finished := False;
     
      // Perform application initialization:
      if not glCreateWnd(640, 480, FALSE, 32) then
      begin
        Result := 0;
        Exit;
      end;
     
      DemoStart := GetTickCount(); // Get Time when demo started
     
      // Main message loop:
      while not finished do
      begin
        // Check if there is a message for this window
        if (PeekMessage(msg, 0, 0, 0, PM_REMOVE)) then
        begin
          // If WM_QUIT message received then we are done
          if (msg.message = WM_QUIT) then
            finished := True
          else
          begin // Else translate and dispatch the message to this window
            TranslateMessage(msg);
            DispatchMessage(msg);
          end;
        end
        else
        begin
          Inc(FPSCount); // Increment FPS Counter
     
          LastTime := ElapsedTime;
          ElapsedTime := GetTickCount() - DemoStart; // Calculate Elapsed Time
          // Average it out for smoother movement
          ElapsedTime := (LastTime + ElapsedTime) div 2;
     
          glDraw(); // Draw the scene
          SwapBuffers(h_DC); // Display the scene
     
          if (keys[VK_ESCAPE]) then // If user pressed ESC then set finised TRUE
            finished := True
          else
            ProcessKeys; // Check for any other key Pressed
        end;
      end;
      glKillWnd(FALSE);
      Result := msg.wParam;
    end;
     
    begin
      WinMain(hInstance, hPrevInst, CmdLine, CmdShow);
    end.

