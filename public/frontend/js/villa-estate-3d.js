// Interactive 3D model of the Villa Fabulosa estate for the home page hero.
//
// Loaded as an ES module only after the page has finished loading (see the
// loader in frontend/home-3d.blade.php), so three.js never competes with the
// poster photo for the LCP. The model is illustrative: the layout follows the
// aerial photos (villa and wing at the back, sports court and lawn in front,
// pool deck between the outdoor-kitchen building and the lounge pavilion,
// mini golf across the road), but it is not to scale.
import * as THREE from './vendor/three-0.170.0.module.min.js';

// Hotspot anchors and the camera view each one flies to. az is the orbit
// angle around the target (0 = from the lawn side), polar the angle down
// from vertical, r the distance.
const SPOTS = {
    pool:     { pin: [10, 1.4, -6.5],   view: { target: [11, 0, -6],    r: 48,  az: 0.5,   polar: 1.1 } },
    villa:    { pin: [-4, 8.6, -18],    view: { target: [-3, 3, -16],   r: 56,  az: 0.15,  polar: 1.18 } },
    game:     { pin: [-9.5, 2.6, -11],  view: { target: [-8, 2, -13],   r: 40,  az: -0.3,  polar: 1.2 } },
    court:    { pin: [-22, 1.6, -3.5],  view: { target: [-21, 0, -3],   r: 44,  az: -0.75, polar: 1.05 } },
    lawn:     { pin: [-7, 1.4, 12],     view: { target: [-6, 0, 9],     r: 52,  az: -0.25, polar: 1.05 } },
    kitchen:  { pin: [15, 4.4, -19],    view: { target: [15, 1.5, -16], r: 44,  az: 0.3,   polar: 1.15 } },
    pavilion: { pin: [24, 4.6, -2.5],   view: { target: [23, 1.5, -3],  r: 40,  az: 0.85,  polar: 1.12 } },
    golf:     { pin: [65, 1.2, 65],     view: { target: [65, 0, 64],    r: 50,  az: 0.35,  polar: 0.98 } },
};
const HOME_VIEW = { target: [4, 0, -4], r: 104, az: -0.55, polar: 1.33 };

const PALETTES = {
    day: {
        skyTop: 0x3f7fd4, skyHorizon: 0xd3e7f5, skyBottom: 0xb9a98d, sunColor: 0xfff1d6,
        fog: 0xc8dbea, hemiSky: 0xcfe2ff, hemiGround: 0x8f7b58, hemi: 1.25,
        sun: 2.8, sunPos: [70, 120, 60], sunTint: 0xfff3e0, glow: 0, exposure: 1.0, stars: 0,
    },
    dusk: {
        skyTop: 0x1a1d5c, skyHorizon: 0xf59fb2, skyBottom: 0x3b2c4c, sunColor: 0xffa070,
        fog: 0xc48da4, hemiSky: 0xdcd5f2, hemiGround: 0x6a5560, hemi: 1.6,
        sun: 1.9, sunPos: [150, 38, 40], sunTint: 0xffb08a, glow: 1, exposure: 1.2, stars: 1,
    },
};

// ── Small deterministic noise for the terrain and scatter ──────────────────
function hash(x, z) {
    const s = Math.sin(x * 127.1 + z * 311.7) * 43758.5453;
    return s - Math.floor(s);
}
function valueNoise(x, z) {
    const xi = Math.floor(x), zi = Math.floor(z);
    const xf = x - xi, zf = z - zi;
    const u = xf * xf * (3 - 2 * xf), v = zf * zf * (3 - 2 * zf);
    const a = hash(xi, zi), b = hash(xi + 1, zi), c = hash(xi, zi + 1), d = hash(xi + 1, zi + 1);
    return a + (b - a) * u + (c - a) * v + (a - b - c + d) * u * v;
}
function fbm(x, z) {
    let f = 0, amp = 0.5, freq = 1;
    for (let i = 0; i < 5; i++) { f += amp * valueNoise(x * freq, z * freq); freq *= 2.03; amp *= 0.5; }
    return f;
}
const PLATEAU_Y = -0.4;
// Flat building pad around the lot, the road and the mini golf terrace;
// rolling hills beyond, rising to mountains at the horizon.
function terrainHeight(x, z) {
    const dx = Math.max(Math.abs(x - 12) - 78, 0);
    const dz = Math.max(Math.abs(z - 22) - 66, 0);
    const d = Math.hypot(dx, dz);
    if (d === 0) return PLATEAU_Y;
    const hills = fbm(x * 0.012, z * 0.012) * 14;
    const mountains = Math.pow(Math.max(Math.hypot(x, z) - 420, 0) / 260, 1.4) * 38 * (0.55 + fbm(x * 0.006 + 7, z * 0.006) * 0.9);
    const ramp = Math.min(d / 110, 1);
    return PLATEAU_Y + (hills * ramp * ramp) + mountains - (d < 12 ? 0 : 0);
}

const easeInOut = t => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

// Builds the renderer, scene and lights shared by both experiences: the
// orbit-and-hotspots hero (mountEstate) and the scroll walkthrough
// (mountEstateWalk). applyLighting(t) blends day (0) to dusk (1).
function createWorld(stage, options) {
    const isSmall = Math.min(window.innerWidth, window.innerHeight) < 700;

    // ── Renderer ───────────────────────────────────────────────────────────
    const renderer = new THREE.WebGLRenderer({ antialias: true, powerPreference: 'high-performance' });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, isSmall ? 1.5 : 1.75));
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.shadowMap.enabled = true;
    // Plain PCF: soft shadows cost a much longer shader compile on
    // integrated GPUs for little visible gain at this scale.
    renderer.shadowMap.type = THREE.PCFShadowMap;
    const canvas = renderer.domElement;
    canvas.className = options.canvasClass || 'estate-hero__canvas';
    canvas.setAttribute('aria-hidden', 'true');
    stage.appendChild(canvas);

    const scene = new THREE.Scene();
    scene.fog = new THREE.Fog(0xc8dbea, 170, 720);
    const camera = new THREE.PerspectiveCamera(40, 1, 0.5, 3000);

    // ── Materials ──────────────────────────────────────────────────────────
    const std = (color, o = {}) => new THREE.MeshStandardMaterial({ color, roughness: 0.85, metalness: 0, ...o });
    const M = {
        wall: std(0xf4f2ed, { roughness: 0.8 }),
        roof: std(0xe8e6e1),
        deck: std(0xdcd6cb, { roughness: 0.92 }),
        coping: std(0xf2efe8, { roughness: 0.6 }),
        turf: std(0x4f9c3b, { roughness: 1 }),
        turfDark: std(0x3f8432, { roughness: 1 }),
        courtBlue: std(0x2f50b6, { roughness: 0.7 }),
        courtTeal: std(0x22a68f, { roughness: 0.7 }),
        line: std(0xffffff, { roughness: 0.6 }),
        gravel: std(0x7b4536, { roughness: 1 }),
        asphalt: std(0x313136, { roughness: 0.95 }),
        paver: std(0x8e8a86, { roughness: 0.95 }),
        greyGravel: std(0xa39d94, { roughness: 1 }),
        black: std(0x1c1d21, { roughness: 0.5, metalness: 0.3 }),
        glass: new THREE.MeshStandardMaterial({ color: 0xc9e8f2, roughness: 0.05, metalness: 0.1, transparent: true, opacity: 0.22, depthWrite: false }),
        window: std(0x1e2633, { roughness: 0.18, metalness: 0.35, emissive: 0xffc98a, emissiveIntensity: 0 }),
        warmPanel: std(0x8b6a4a, { emissive: 0xffb466, emissiveIntensity: 0 }),
        downlight: std(0xffffff, { emissive: 0xfff0d0, emissiveIntensity: 0 }),
        navy: std(0x24307a, { roughness: 0.9 }),
        wicker: std(0x5a4636, { roughness: 1 }),
        cushion: std(0x5d6f9e, { roughness: 1 }),
        loungerWhite: std(0xffffff, { roughness: 0.35 }),
        stone: std(0x3b3b40, { roughness: 0.5 }),
        yellow: std(0xf2d33c, { roughness: 0.6 }),
        net: new THREE.MeshStandardMaterial({ color: 0xffffff, transparent: true, opacity: 0.35, depthWrite: false }),
        flag: std(0xd8322f),
        wood: std(0x8a5a32),
        greenery: std(0x76874a, { roughness: 1 }),
        cypress: std(0x4f6e3a, { roughness: 1 }),
        trunk: std(0x5a4632),
        solar: std(0x1b2b55, { roughness: 0.25, metalness: 0.5 }),
        neighbour: std(0xe9e4da),
        neighbourRoof: std(0x77706a),
        flame: new THREE.MeshBasicMaterial({ color: 0xffa040 }),
        putting: std(0x5fae3e, { roughness: 1 }),
    };

    const unitBox = new THREE.BoxGeometry(1, 1, 1);
    // Axis-aligned box from bounds; most of the estate is built from these.
    function block(mat, x0, x1, y0, y1, z0, z1, { cast = true, receive = true, parent = scene } = {}) {
        const m = new THREE.Mesh(unitBox, mat);
        m.scale.set(x1 - x0, y1 - y0, z1 - z0);
        m.position.set((x0 + x1) / 2, (y0 + y1) / 2, (z0 + z1) / 2);
        m.castShadow = cast;
        m.receiveShadow = receive;
        parent.add(m);
        return m;
    }
    const flat = (mat, x0, x1, y, z0, z1) => block(mat, x0, x1, y - 0.04, y, z0, z1, { cast: false });

    // Instanced boxes for anything repeated many times.
    function instancedBoxes(mat, items, { cast = true } = {}) {
        const mesh = new THREE.InstancedMesh(unitBox, mat, items.length);
        const o = new THREE.Object3D();
        items.forEach((it, i) => {
            o.position.set(it.x, it.y, it.z);
            o.rotation.set(it.rx || 0, it.ry || 0, it.rz || 0);
            o.scale.set(it.sx, it.sy, it.sz);
            o.updateMatrix();
            mesh.setMatrixAt(i, o.matrix);
        });
        mesh.castShadow = cast;
        mesh.receiveShadow = true;
        scene.add(mesh);
        return mesh;
    }

    // ── Sky, stars, terrain ───────────────────────────────────────────────
    const skyUniforms = {
        uTop: { value: new THREE.Color() }, uHorizon: { value: new THREE.Color() },
        uBottom: { value: new THREE.Color() }, uSunColor: { value: new THREE.Color() },
        uSunDir: { value: new THREE.Vector3(0, 1, 0) },
    };
    const sky = new THREE.Mesh(
        new THREE.SphereGeometry(1800, 32, 16),
        new THREE.ShaderMaterial({
            uniforms: skyUniforms, side: THREE.BackSide, depthWrite: false, fog: false,
            vertexShader: `varying vec3 vDir; void main(){ vDir = normalize(position); gl_Position = projectionMatrix * modelViewMatrix * vec4(position,1.0); }`,
            fragmentShader: `
                uniform vec3 uTop; uniform vec3 uHorizon; uniform vec3 uBottom; uniform vec3 uSunColor; uniform vec3 uSunDir;
                varying vec3 vDir;
                void main(){
                    vec3 d = normalize(vDir);
                    float h = d.y;
                    vec3 col = h > 0.0 ? mix(uHorizon, uTop, pow(clamp(h, 0.0, 1.0), 0.5)) : mix(uHorizon, uBottom, clamp(-h * 5.0, 0.0, 1.0));
                    float s = max(dot(d, normalize(uSunDir)), 0.0);
                    col += uSunColor * (pow(s, 900.0) * 3.0 + pow(s, 10.0) * 0.45);
                    gl_FragColor = vec4(col, 1.0);
                    #include <tonemapping_fragment>
                    #include <colorspace_fragment>
                }`,
        })
    );
    sky.renderOrder = -1;
    scene.add(sky);

    const starGeo = new THREE.BufferGeometry();
    const starPos = [];
    for (let i = 0; i < 700; i++) {
        const theta = hash(i, 1) * Math.PI * 2, y = 0.12 + hash(i, 2) * 0.88;
        const rr = Math.sqrt(1 - y * y);
        starPos.push(Math.cos(theta) * rr * 1500, y * 1500, Math.sin(theta) * rr * 1500);
    }
    starGeo.setAttribute('position', new THREE.Float32BufferAttribute(starPos, 3));
    const starMat = new THREE.PointsMaterial({ color: 0xffffff, size: 2.2, sizeAttenuation: false, transparent: true, opacity: 0, fog: false, depthWrite: false });
    scene.add(new THREE.Points(starGeo, starMat));

    const TERRAIN = 1400, SEG = isSmall ? 160 : 220;
    const tGeo = new THREE.PlaneGeometry(TERRAIN, TERRAIN, SEG, SEG);
    tGeo.rotateX(-Math.PI / 2);
    const tPos = tGeo.attributes.position, tCol = [];
    const dry = new THREE.Color(0xb59a6b), sage = new THREE.Color(0x7d8150), dark = new THREE.Color(0x6b5a45), rock = new THREE.Color(0x8d7f73);
    const tmp = new THREE.Color();
    for (let i = 0; i < tPos.count; i++) {
        const x = tPos.getX(i), z = tPos.getZ(i);
        const y = terrainHeight(x, z);
        tPos.setY(i, y);
        const n = fbm(x * 0.05 + 3, z * 0.05);
        tmp.copy(dry).lerp(sage, Math.min(Math.max((n - 0.35) * 2.2, 0), 1)).lerp(dark, hash(x, z) * 0.18);
        if (y > 40) tmp.lerp(rock, Math.min((y - 40) / 80, 0.8));
        tCol.push(tmp.r, tmp.g, tmp.b);
    }
    tGeo.setAttribute('color', new THREE.Float32BufferAttribute(tCol, 3));
    tGeo.computeVertexNormals();
    const terrain = new THREE.Mesh(tGeo, new THREE.MeshStandardMaterial({ vertexColors: true, roughness: 1 }));
    terrain.receiveShadow = true;
    scene.add(terrain);

    // ── Lot: gravel ring, paving, parking ─────────────────────────────────
    block(M.gravel, -37, 37, -0.42, -0.06, -38, 28, { cast: false });
    block(M.deck, -30, 30, -0.4, 0, -32, 22, { cast: false });
    block(M.paver, -44, -30.3, -0.42, -0.03, -32, -4, { cast: false });

    // Roads: a ribbon that follows the terrain, plus the driveway branch.
    function road(points, width, mat) {
        const curve = new THREE.CatmullRomCurve3(points.map(([x, z]) => new THREE.Vector3(x, 0, z)));
        const pts = curve.getSpacedPoints(Math.round(curve.getLength() / 2));
        const pos = [], idx = [];
        pts.forEach((p, i) => {
            const next = pts[Math.min(i + 1, pts.length - 1)], prev = pts[Math.max(i - 1, 0)];
            const dir = new THREE.Vector3().subVectors(next, prev).normalize();
            const side = new THREE.Vector3(-dir.z, 0, dir.x).multiplyScalar(width / 2);
            const a = p.clone().add(side), b = p.clone().sub(side);
            pos.push(a.x, terrainHeight(a.x, a.z) + 0.08, a.z, b.x, terrainHeight(b.x, b.z) + 0.08, b.z);
            if (i < pts.length - 1) { const k = i * 2; idx.push(k, k + 1, k + 2, k + 1, k + 3, k + 2); }
        });
        const g = new THREE.BufferGeometry();
        g.setAttribute('position', new THREE.Float32BufferAttribute(pos, 3));
        g.setIndex(idx);
        g.computeVertexNormals();
        const m = new THREE.Mesh(g, mat);
        m.receiveShadow = true;
        scene.add(m);
    }
    road([[-260, 70], [-150, 46], [-80, 44], [-40, 40], [0, 43], [40, 46], [90, 40], [150, 18], [260, -10]], 6, M.asphalt);
    road([[-37, -6], [-38.5, 10], [-40, 26], [-41, 41]], 5.5, M.asphalt);

    // ── Main villa (two storeys) and its single-storey wing ───────────────
    block(M.wall, -12, 6, 0, 3.6, -25, -11);
    block(M.roof, -12.3, 6.3, 3.5, 3.9, -25.3, -10.6);
    block(M.wall, -12, 4, 3.9, 7.2, -25, -12.6);
    block(M.roof, -12.5, 4.5, 7.2, 7.65, -25.5, -12.1);
    block(M.glass, -9, -1, 3.9, 4.95, -10.75, -10.65, { cast: false });
    // Covered patio off the living room.
    block(M.roof, -1, 9.5, 3.35, 3.8, -11, -6.4);
    block(M.wall, 8.6, 9.2, 0, 3.35, -7.1, -6.5);
    block(M.wall, -0.7, -0.1, 0, 3.35, -7.1, -6.5);
    // Windows: ground floor and upper floor, front and pool-side facades.
    [[-11.2, -8.6], [-7, -3.2], [-1.8, 2.6], [3.4, 5.4]].forEach(([a, b]) => block(M.window, a, b, 0.25, 3.05, -11.06, -10.94, { cast: false }));
    [[-11.2, -9.4], [-7.6, -2.4], [-1.2, 3.2]].forEach(([a, b]) => block(M.window, a, b, 4.2, 6.7, -12.66, -12.54, { cast: false }));
    [[-22.5, -19.5], [-17.5, -13]].forEach(([a, b]) => block(M.window, 5.94, 6.06, 0.6, 3.0, a, b, { cast: false }));
    [[-21.5, -17], [-15.5, -13.5]].forEach(([a, b]) => block(M.window, 3.94, 4.06, 4.3, 6.6, a, b, { cast: false }));
    // Patio ceiling downlights.
    for (let x = 0.5; x < 9; x += 2.2) block(M.downlight, x - 0.18, x + 0.18, 3.3, 3.36, -9.1, -8.75, { cast: false });
    // Wing.
    block(M.wall, -21, -12, 0, 3.4, -24, -13);
    block(M.roof, -21.3, -12, 3.4, 3.75, -24.3, -12.7);
    block(M.window, -19.2, -17.8, 0, 2.4, -13.06, -12.94, { cast: false });
    block(M.window, -16.4, -13.4, 1.0, 2.6, -13.06, -12.94, { cast: false });
    // Back yard with the children's play set.
    flat(M.turf, -21, 6, 0.03, -31.6, -25.3);
    block(M.wood, -2, 0.5, 0, 2.3, -29.6, -27.6);
    block(M.roof, -2.3, 0.8, 2.3, 2.6, -29.9, -27.3);
    block(M.yellow, 0.5, 1.2, 0, 0.6, -29.2, -27.2).rotation.z = -0.6;

    // ── Back building: outdoor kitchen and bar facing the pool ────────────
    block(M.wall, 6, 29, 0, 3.6, -26, -20);
    block(M.roof, 5.7, 29.3, 3.6, 4.0, -26.3, -16.3);
    [6.5, 17.5, 28.5].forEach(x => block(M.wall, x - 0.3, x + 0.3, 0, 3.6, -17.1, -16.5));
    block(M.warmPanel, 8, 22, 0.3, 3.3, -20.08, -19.96, { cast: false });
    block(M.black, 11, 13.4, 2.0, 3.0, -19.96, -19.9, { cast: false });
    block(M.stone, 9, 21, 0, 1.1, -19.2, -18.4);
    block(M.window, 23, 28, 0.8, 3.0, -20.06, -19.94, { cast: false });
    for (let x = 7.5; x < 29; x += 2.5) block(M.downlight, x - 0.18, x + 0.18, 3.55, 3.6, -18.5, -18.1, { cast: false });
    instancedBoxes(M.black, Array.from({ length: 10 }, (_, i) => ({ x: 9.6 + i * 1.2, y: 0.4, z: -17.8, sx: 0.45, sy: 0.8, sz: 0.45 })));

    // ── Lounge pavilion ────────────────────────────────────────────────────
    block(M.roof, 19, 29, 3.3, 3.8, -8, 3);
    [[19.4, -7.6], [28.6, -7.6], [19.4, 2.6], [28.6, 2.6]].forEach(([x, z]) => block(M.wall, x - 0.3, x + 0.3, 0, 3.3, z - 0.3, z + 0.3));
    for (let x = 20.5; x < 28; x += 2.4) for (const z of [-5.5, 0.5]) block(M.downlight, x - 0.18, x + 0.18, 3.25, 3.3, z - 0.18, z + 0.18, { cast: false });
    // Two sofas facing each other across a fire table.
    for (const [z0, z1, back] of [[-6.6, -5.4, [-6.6, -6.2]], [0.4, 1.6, [1.2, 1.6]]]) {
        block(M.wicker, 20.6, 26.6, 0, 0.45, z0, z1);
        block(M.cushion, 20.7, 26.5, 0.45, 0.62, z0 + 0.1, z1 - 0.1);
        block(M.wicker, 20.6, 26.6, 0.45, 1.0, back[0], back[1]);
    }
    block(M.stone, 22.4, 24.8, 0, 0.5, -3.3, -1.7);
    block(M.flame, 22.7, 24.5, 0.5, 0.64, -2.9, -2.1, { cast: false });

    // ── Pool, spa and Baja shelves ─────────────────────────────────────────
    const waterUniforms = { uTime: { value: 0 }, uGlow: { value: 0 } };
    const waterMat = (shallow) => new THREE.ShaderMaterial({
        uniforms: { ...waterUniforms, uShallow: { value: shallow } },
        vertexShader: `varying vec3 vPos; void main(){ vec4 w = modelMatrix * vec4(position,1.0); vPos = w.xyz; gl_Position = projectionMatrix * viewMatrix * w; }`,
        fragmentShader: `
            uniform float uTime; uniform float uGlow; uniform float uShallow; varying vec3 vPos;
            float caustic(vec2 p){
                float t = uTime * 0.55; vec2 q = p; float c = 0.0;
                for (int i = 0; i < 3; i++) {
                    q += vec2(sin(q.y * 1.7 + t), cos(q.x * 1.3 - t * 0.8)) * 0.55;
                    c += abs(sin(q.x * 2.1) + cos(q.y * 2.3));
                }
                return c / 6.0;
            }
            void main(){
                float c = caustic(vPos.xz * 0.85);
                vec3 deep = mix(vec3(0.03, 0.42, 0.62), vec3(0.0, 0.62, 1.0), uGlow);
                vec3 lite = mix(vec3(0.62, 0.92, 0.98), vec3(0.65, 0.95, 1.0), uGlow);
                deep = mix(deep, lite * 0.85, uShallow * 0.55);
                vec3 col = mix(deep, lite, smoothstep(0.68, 1.15, c));
                col *= mix(1.0, 1.55, uGlow);
                gl_FragColor = vec4(col, 1.0);
                #include <tonemapping_fragment>
                #include <colorspace_fragment>
            }`,
    });
    const deepWater = waterMat(0), shallowWater = waterMat(1);
    // Coping frame around the pool (inner water area x 4..15, z -10..-3).
    block(M.coping, 3.5, 15.5, 0, 0.14, -10.5, -10);
    block(M.coping, 3.5, 15.5, 0, 0.14, -3, -2.5);
    block(M.coping, 3.5, 4, 0, 0.14, -10, -3);
    block(M.coping, 15, 15.5, 0, 0.14, -10, -3);
    flat(deepWater, 6.5, 12.5, 0.09, -10, -3);
    flat(shallowWater, 4, 6.5, 0.1, -10, -3);
    flat(shallowWater, 12.5, 15, 0.1, -10, -3);
    // Raised spa off the deep end.
    block(M.coping, 15.5, 19, 0, 0.42, -10.5, -6.5);
    flat(deepWater, 15.9, 18.6, 0.44, -10.1, -6.9);
    // In-pool loungers on both shelves.
    const loungers = [];
    for (const [x, z] of [[4.6, -9], [4.6, -6.6], [4.6, -4.2], [13.4, -8], [13.4, -5.2]]) {
        loungers.push({ x, y: 0.2, z, sx: 0.75, sy: 0.18, sz: 1.9 });
        loungers.push({ x: x + (x < 10 ? 0.0 : 0.0), y: 0.42, z: z - 0.75, sx: 0.75, sy: 0.12, sz: 0.6, rx: -0.6 });
    }
    instancedBoxes(M.loungerWhite, loungers);
    // Turf strip and navy loungers along the lawn side of the pool.
    flat(M.turf, 3, 16, 0.04, -2.4, -0.3);
    const navy = [];
    for (let x = 4.4; x < 15.5; x += 1.9) {
        navy.push({ x, y: 0.32, z: -1.35, sx: 0.8, sy: 0.14, sz: 1.5 });
        navy.push({ x, y: 0.58, z: -0.55, sx: 0.8, sy: 0.12, sz: 0.7, rx: 0.65 });
    }
    for (let x = 5; x < 15; x += 2.2) navy.push({ x, y: 0.32, z: -12, sx: 0.8, sy: 0.14, sz: 1.6 });
    instancedBoxes(M.navy, navy);
    // Ping-pong table between the pool and the lawn.
    block(M.courtBlue, -1.4, 1.4, 0.72, 0.8, -1.9, -0.4);
    block(M.black, -1.3, 1.3, 0, 0.72, -1.8, -0.5);
    block(M.net, -1.45, 1.45, 0.8, 0.95, -1.17, -1.13, { cast: false });

    // ── Sports court ───────────────────────────────────────────────────────
    flat(M.courtTeal, -29.5, -14.5, 0.04, -9.8, 2.8);
    flat(M.courtBlue, -28.4, -15.6, 0.05, -8.7, 1.7);
    const lines = [
        [-28.4, -15.6, -8.7, -8.55], [-28.4, -15.6, 1.55, 1.7], [-28.4, -28.25, -8.7, 1.7], [-15.75, -15.6, -8.7, 1.7],
        [-22.08, -21.92, -8.7, 1.7], [-28.4, -24.6, -5.2, -5.05], [-28.4, -24.6, -1.9, -1.75], [-24.75, -24.6, -5.2, -1.75],
        [-19.4, -15.6, -5.2, -5.05], [-19.4, -15.6, -1.9, -1.75], [-19.4, -19.25, -5.2, -1.75],
    ];
    lines.forEach(([a, b, c, d]) => flat(M.line, a, b, 0.06, c, d));
    block(M.black, -22.05, -21.95, 0, 0.95, -8.3, 1.3);
    block(M.net, -22.03, -21.97, 0.3, 0.95, -8.3, 1.3, { cast: false });
    block(M.black, -29.9, -29.6, 0, 3.6, -3.65, -3.35);
    block(M.line, -29.6, -29.45, 2.8, 3.9, -4.4, -2.6);
    const rim = new THREE.Mesh(new THREE.TorusGeometry(0.3, 0.035, 8, 20), std(0xe0602a));
    rim.rotation.x = Math.PI / 2;
    rim.position.set(-29.1, 3.05, -3.5);
    scene.add(rim);

    // ── Lawn: volleyball, bocce lanes, putting cups ───────────────────────
    flat(M.turf, -29.5, 18, 0.03, 2.8, 21.6);
    flat(M.turf, -14.5, -2.2, 0.03, -9.8, 2.8);
    flat(M.putting, -13.8, -3, 0.045, -8.6, 1.2);
    for (const z0 of [4.2, 7.4]) {
        flat(M.turfDark, -28, -6, 0.05, z0, z0 + 1.8);
        block(M.wood, -28, -6, 0, 0.18, z0, z0 + 0.12);
        block(M.wood, -28, -6, 0, 0.18, z0 + 1.68, z0 + 1.8);
        block(M.wood, -28, -27.88, 0, 0.18, z0, z0 + 1.8);
        block(M.wood, -6.12, -6, 0, 0.18, z0, z0 + 1.8);
    }
    for (const [x, z] of [[-12, -6.5], [-6, -1.5], [-9, 0.2], [-4.2, -7.3]]) {
        block(M.line, x - 0.03, x + 0.03, 0, 1.35, z - 0.03, z + 0.03, { cast: false });
        block(M.flag, x + 0.03, x + 0.5, 1.0, 1.3, z - 0.01, z + 0.01, { cast: false });
    }
    for (const z of [5, 19]) block(M.yellow, 2.85, 3.15, 0, 2.5, z - 0.15, z + 0.15);
    block(M.net, 2.97, 3.03, 1.45, 2.35, 5, 19, { cast: false });
    block(M.line, 2.95, 3.05, 2.33, 2.42, 5, 19, { cast: false });
    // Cypress trees along the inside of the front glass fence.
    const cypress = new THREE.InstancedMesh(new THREE.ConeGeometry(0.45, 2.6, 8), M.cypress, 22);
    { const o = new THREE.Object3D(); let i = 0;
      for (let x = -27; x <= 27 && i < 14; x += 4) { o.position.set(x, 1.3, 20.8); o.updateMatrix(); cypress.setMatrixAt(i++, o.matrix); }
      for (let z = -6; z <= 18 && i < 22; z += 3.4) { o.position.set(28.8, 1.3, z); o.updateMatrix(); cypress.setMatrixAt(i++, o.matrix); }
      cypress.count = i; }
    cypress.castShadow = true;
    scene.add(cypress);

    // ── Perimeter: white base wall with glass panels, solid walls at the back
    block(M.wall, -30.3, 30.3, 0, 0.7, 21.8, 22.2);
    block(M.wall, -30.2, -29.8, 0, 0.7, -12, 22);
    block(M.wall, -30.2, -29.8, 0, 2.2, -32, -12);
    block(M.wall, -30.2, 30.2, 0, 2.2, -32.2, -31.8);
    block(M.wall, 29.8, 30.2, 0, 0.7, -16, 22);
    block(M.wall, 29.8, 30.2, 0, 2.2, -32, -16);
    block(M.glass, -30, 30, 0.7, 1.95, 21.96, 22.04, { cast: false });
    block(M.glass, -30.04, -29.96, 0.7, 1.95, -12, 22, { cast: false });
    block(M.glass, 29.96, 30.04, 0.7, 1.95, -16, 22, { cast: false });
    const posts = [];
    for (let x = -30; x <= 30; x += 2.5) posts.push({ x, y: 1.3, z: 22, sx: 0.09, sy: 1.3, sz: 0.09 });
    for (let z = -12; z < 22; z += 2.5) posts.push({ x: -30, y: 1.3, z, sx: 0.09, sy: 1.3, sz: 0.09 });
    for (let z = -16; z < 22; z += 2.5) posts.push({ x: 30, y: 1.3, z, sx: 0.09, sy: 1.3, sz: 0.09 });
    instancedBoxes(M.black, posts, { cast: false });

    // ── Surroundings: vines, solar array, mini golf, trees, neighbours ────
    // Vine rows on the slope beside the drive.
    const vines = [];
    for (let x = -74; x < -48; x += 2.2) vines.push({ x, y: PLATEAU_Y + 0.35, z: -4, sx: 0.55, sy: 0.7, sz: 52 });
    instancedBoxes(M.cypress, vines, { cast: false });
    const solar = [];
    for (let i = 0; i < 4; i++) solar.push({ x: 43 + i * 4.5, y: PLATEAU_Y + 1.1, z: 6, sx: 3.2, sy: 0.12, sz: 26, rz: 0.42 });
    instancedBoxes(M.solar, solar);

    // Mini golf terrace: 18 framed greens, three columns of long lanes
    // running up the slope, as in the aerial photo.
    block(M.greyGravel, 51, 79, PLATEAU_Y - 0.1, PLATEAU_Y + 0.1, 49, 80, { cast: false });
    const greens = [], frames = [];
    [[1.7, 4.4], [1.7, 4.2], [1.6, 3.9], [1.6, 3.6], [1.5, 3.3], [1.5, 3.0]].forEach(([w, len], r) => {
        for (let c = 0; c < 3; c++) {
            const x = 57.5 + c * 7.5, z = 53 + r * 4.9;
            greens.push({ x, y: PLATEAU_Y + 0.17, z, sx: w, sy: 0.12, sz: len });
            frames.push({ x, y: PLATEAU_Y + 0.14, z, sx: w + 0.3, sy: 0.16, sz: len + 0.3 });
        }
    });
    instancedBoxes(M.wood, frames, { cast: false });
    instancedBoxes(M.putting, greens, { cast: false });

    // Scattered trees and a few neighbouring houses for scale.
    const treeGeo = new THREE.IcosahedronGeometry(1, 1);
    const trees = new THREE.InstancedMesh(treeGeo, M.greenery, 160);
    { const o = new THREE.Object3D(); let n = 0;
      for (let i = 0; n < 160 && i < 2000; i++) {
          const a = hash(i, 9) * Math.PI * 2, d = 55 + Math.pow(hash(i, 4), 0.7) * 260;
          const x = Math.cos(a) * d, z = Math.sin(a) * d + 10;
          if (x > 40 && x < 90 && z > 45 && z < 85) continue; // keep the golf terrace clear
          if (Math.abs(z - (43 + x * 0.02)) < 7 && Math.abs(x) < 140) continue; // and the road
          const s = 1.6 + hash(i, 7) * 2.6;
          o.position.set(x, terrainHeight(x, z) + s * 0.9, z);
          o.scale.set(s, s * 0.85, s);
          o.updateMatrix();
          trees.setMatrixAt(n++, o.matrix);
      }
      trees.count = n; }
    trees.castShadow = true;
    scene.add(trees);
    for (let i = 0; i < 12; i++) {
        const a = hash(i, 21) * Math.PI * 2, d = 140 + hash(i, 22) * 220;
        const x = Math.cos(a) * d, z = Math.sin(a) * d;
        const y = terrainHeight(x, z), w = 10 + hash(i, 23) * 10, l = 8 + hash(i, 24) * 8;
        const g = new THREE.Group();
        block(M.neighbour, -w / 2, w / 2, 0, 3.4, -l / 2, l / 2, { parent: g });
        block(M.neighbourRoof, -w / 2 - 0.5, w / 2 + 0.5, 3.4, 3.9, -l / 2 - 0.5, l / 2 + 0.5, { parent: g });
        g.position.set(x, y - 0.5, z);
        g.rotation.y = hash(i, 25) * Math.PI;
        scene.add(g);
    }

    // ── Lights ─────────────────────────────────────────────────────────────
    const hemi = new THREE.HemisphereLight(0xffffff, 0x888888, 1);
    scene.add(hemi);
    const sun = new THREE.DirectionalLight(0xffffff, 2);
    sun.castShadow = true;
    sun.shadow.mapSize.set(isSmall ? 1024 : 2048, isSmall ? 1024 : 2048);
    Object.assign(sun.shadow.camera, { left: -70, right: 70, top: 70, bottom: -70, near: 1, far: 500 });
    sun.shadow.bias = -0.0004;
    sun.shadow.normalBias = 0.03;
    sun.target.position.set(0, 0, -5);
    scene.add(sun, sun.target);
    const poolLight = new THREE.PointLight(0x5fd8ff, 0, 30, 2);
    poolLight.position.set(10, 1.2, -6.5);
    const warmLights = [[3.8, 3.0, -8.8], [15, 3.2, -18.5], [24, 3.0, -2.5]].map(([x, y, z]) => {
        const l = new THREE.PointLight(0xffc27a, 0, 22, 2);
        l.position.set(x, y, z);
        scene.add(l);
        return l;
    });
    scene.add(poolLight);

    // ── Day / dusk ─────────────────────────────────────────────────────────
    const cA = new THREE.Color(), cB = new THREE.Color();
    const mixHex = (a, b, t, out) => out.copy(cA.set(a)).lerp(cB.set(b), t);
    function applyLighting(t) {
        const D = PALETTES.day, N = PALETTES.dusk, L = (a, b) => a + (b - a) * t;
        mixHex(D.skyTop, N.skyTop, t, skyUniforms.uTop.value);
        mixHex(D.skyHorizon, N.skyHorizon, t, skyUniforms.uHorizon.value);
        mixHex(D.skyBottom, N.skyBottom, t, skyUniforms.uBottom.value);
        mixHex(D.sunColor, N.sunColor, t, skyUniforms.uSunColor.value);
        mixHex(D.fog, N.fog, t, scene.fog.color);
        mixHex(D.hemiSky, N.hemiSky, t, hemi.color);
        mixHex(D.hemiGround, N.hemiGround, t, hemi.groundColor);
        hemi.intensity = L(D.hemi, N.hemi);
        mixHex(D.sunTint, N.sunTint, t, sun.color);
        sun.intensity = L(D.sun, N.sun);
        sun.position.set(L(D.sunPos[0], N.sunPos[0]), L(D.sunPos[1], N.sunPos[1]), L(D.sunPos[2], N.sunPos[2]));
        skyUniforms.uSunDir.value.copy(sun.position).normalize();
        renderer.toneMappingExposure = L(D.exposure, N.exposure);
        starMat.opacity = Math.max(0, t - 0.4) * 1.4;
        M.window.emissiveIntensity = t * 1.1;
        M.warmPanel.emissiveIntensity = t * 1.4;
        M.downlight.emissiveIntensity = 0.2 + t * 3;
        waterUniforms.uGlow.value = t;
        poolLight.intensity = t * 260;
        warmLights.forEach(l => { l.intensity = t * 140; });
        M.flame.color.setHSL(0.08, 1, 0.45 + t * 0.15);
    }

    // Compile every shader before the first frame without blocking the main
    // thread (parallel where the driver supports it), so scrolling never
    // freezes while the model warms up. Resolves once it is safe to render.
    function warmUp() {
        return renderer.compileAsync(scene, camera).catch(() => {});
    }

    return { renderer, scene, camera, canvas, applyLighting, waterUniforms, warmUp };
}

export function mountEstate(stage, options = {}) {
    const reducedMotion = !!options.reducedMotion;
    const { renderer, scene, camera, canvas, applyLighting, waterUniforms, warmUp } = createWorld(stage, options);
    let duskT = options.mode === 'day' ? 0 : 1, duskGoal = duskT;
    applyLighting(duskT);

    // ── Camera rig: orbit, drag, fly-to ───────────────────────────────────
    const view = { target: new THREE.Vector3(...HOME_VIEW.target), r: HOME_VIEW.r, az: HOME_VIEW.az, polar: HOME_VIEW.polar };
    let flight = null, autoRotate = !reducedMotion, lastInteraction = 0, focused = null;
    // Pull back on portrait screens so the whole lot still fits.
    const aspectScale = () => Math.min(Math.max(1.3 / camera.aspect, 1), 1.75);

    function placeCamera() {
        const r = view.r * (focused ? Math.min(aspectScale(), 1.5) : aspectScale());
        const s = Math.sin(view.polar);
        camera.position.set(view.target.x + r * s * Math.sin(view.az), view.target.y + r * Math.cos(view.polar), view.target.z + r * s * Math.cos(view.az));
        camera.lookAt(view.target);
    }
    function flyTo(v, instant) {
        const to = { target: new THREE.Vector3(...v.target), r: v.r, polar: v.polar, az: v.az };
        // Take the short way round.
        let d = to.az - view.az;
        d = ((d + Math.PI) % (Math.PI * 2) + Math.PI * 2) % (Math.PI * 2) - Math.PI;
        to.az = view.az + d;
        if (instant || reducedMotion) { Object.assign(view, { r: to.r, polar: to.polar, az: to.az }); view.target.copy(to.target); flight = null; return; }
        flight = { from: { target: view.target.clone(), r: view.r, polar: view.polar, az: view.az }, to, t: 0, dur: 1.7 };
    }

    let dragging = null;
    canvas.addEventListener('pointerdown', e => {
        dragging = { x: e.clientX, y: e.clientY, id: e.pointerId, type: e.pointerType };
        flight = null;
        lastInteraction = performance.now();
        stage.classList.add('is-dragging');
    });
    window.addEventListener('pointermove', e => {
        if (!dragging || e.pointerId !== dragging.id) return;
        const dx = e.clientX - dragging.x, dy = e.clientY - dragging.y;
        dragging.x = e.clientX; dragging.y = e.clientY;
        view.az -= dx * 0.0055;
        // Touch keeps vertical swipes for page scrolling (touch-action: pan-y).
        if (dragging.type !== 'touch') view.polar = Math.min(Math.max(view.polar - dy * 0.004, 0.42), 1.32);
        lastInteraction = performance.now();
    });
    const endDrag = () => { dragging = null; stage.classList.remove('is-dragging'); };
    window.addEventListener('pointerup', endDrag);
    window.addEventListener('pointercancel', endDrag);

    // ── Pins: DOM labels that track their 3D anchors ──────────────────────
    const pinLayer = document.createElement('div');
    pinLayer.className = 'estate-hero__pins';
    pinLayer.setAttribute('aria-hidden', 'true');
    stage.appendChild(pinLayer);
    const pins = Object.entries(SPOTS).map(([id, s]) => {
        const el = document.createElement('button');
        el.type = 'button';
        el.tabIndex = -1; // keyboard users get the same choices from the chip list
        el.className = 'estate-pin';
        el.dataset.spot = id;
        el.innerHTML = '<span class="estate-pin__dot"></span><span class="estate-pin__label"></span>';
        el.querySelector('.estate-pin__label').textContent = (options.labels && options.labels[id]) || id;
        el.addEventListener('click', () => options.onPick && options.onPick(id));
        pinLayer.appendChild(el);
        return { id, el, anchor: new THREE.Vector3(...s.pin) };
    });
    const projected = new THREE.Vector3();
    function updatePins(w, h) {
        pins.forEach(p => {
            projected.copy(p.anchor).project(camera);
            const visible = projected.z < 1 && Math.abs(projected.x) < 1.1 && Math.abs(projected.y) < 1.1;
            p.el.style.transform = `translate(${((projected.x + 1) / 2 * w).toFixed(1)}px, ${((1 - projected.y) / 2 * h).toFixed(1)}px)`;
            p.el.classList.toggle('is-hidden', !visible);
            p.el.classList.toggle('is-active', p.id === focused);
        });
    }

    // ── Loop ───────────────────────────────────────────────────────────────
    let width = 0, height = 0, running = true, visible = true, raf = 0, last = performance.now();
    // Where the orbit target lands on screen, as a fraction of the stage.
    // On wide screens the model sits right of the headline, and left of the
    // spot card once one is open; on narrow screens it rises above the card.
    const frameAt = { x: 0.5, y: 0.5 };
    const frameGoal = () => (width >= 992
        ? { x: focused ? 0.4 : 0.66, y: focused ? 0.52 : 0.6 }
        : { x: 0.5, y: focused ? 0.32 : 0.46 });
    function applyFraming() {
        const fw = width * (1 + 2 * Math.abs(frameAt.x - 0.5)), fh = height * (1 + 2 * Math.abs(frameAt.y - 0.5));
        camera.setViewOffset(fw, fh, frameAt.x < 0.5 ? fw - width : 0, frameAt.y < 0.5 ? fh - height : 0, width, height);
    }
    function resize() {
        width = stage.clientWidth; height = stage.clientHeight;
        if (!width || !height) return;
        renderer.setSize(width, height, false);
        camera.aspect = width / height;
        Object.assign(frameAt, frameGoal());
        applyFraming();
    }
    const ro = new ResizeObserver(resize);
    ro.observe(stage);
    resize();

    function frame(now) {
        raf = 0;
        if (!running || !visible || document.hidden) return;
        const dt = Math.min((now - last) / 1000, 0.05);
        last = now;
        waterUniforms.uTime.value += dt;
        if (duskT !== duskGoal) {
            duskT += Math.sign(duskGoal - duskT) * dt / (reducedMotion ? 0.01 : 1.4);
            duskT = Math.min(Math.max(duskT, 0), 1);
            if (Math.abs(duskT - duskGoal) < 0.002) duskT = duskGoal;
            applyLighting(duskT);
        }
        if (flight) {
            flight.t = Math.min(flight.t + dt / flight.dur, 1);
            const k = easeInOut(flight.t), f = flight.from, t = flight.to;
            view.target.lerpVectors(f.target, t.target, k);
            view.r = f.r + (t.r - f.r) * k;
            view.polar = f.polar + (t.polar - f.polar) * k;
            view.az = f.az + (t.az - f.az) * k;
            if (flight.t >= 1) flight = null;
        } else if (autoRotate && !dragging && !focused && now - lastInteraction > 5000) {
            view.az += dt * 0.045;
        }
        const goal = frameGoal(), ease = reducedMotion ? 1 : Math.min(dt * 3, 1);
        if (Math.abs(goal.x - frameAt.x) > 0.001 || Math.abs(goal.y - frameAt.y) > 0.001) {
            frameAt.x += (goal.x - frameAt.x) * ease;
            frameAt.y += (goal.y - frameAt.y) * ease;
            applyFraming();
        }
        placeCamera();
        renderer.render(scene, camera);
        updatePins(width, height);
        raf = requestAnimationFrame(frame);
    }
    let ready = false;
    const kick = () => { if (ready && !raf && running && visible && !document.hidden) { last = performance.now(); raf = requestAnimationFrame(frame); } };
    const io = new IntersectionObserver(entries => { visible = entries[0].isIntersecting; kick(); });
    io.observe(stage);
    document.addEventListener('visibilitychange', kick);
    canvas.addEventListener('webglcontextlost', e => { e.preventDefault(); running = false; options.onLost && options.onLost(); });

    placeCamera();
    warmUp().then(() => {
        if (!running) return;
        ready = true;
        renderer.render(scene, camera);
        options.onReady && options.onReady();
        kick();
    });

    return {
        focus(id) {
            const s = SPOTS[id];
            if (!s) return;
            focused = id;
            flyTo(s.view);
            kick();
        },
        reset() {
            focused = null;
            flyTo(HOME_VIEW);
            lastInteraction = performance.now();
            kick();
        },
        setMode(mode) { duskGoal = mode === 'day' ? 0 : 1; kick(); },
        setAutoRotate(on) { autoRotate = !!on && !reducedMotion; lastInteraction = 0; kick(); },
        destroy() {
            running = false;
            cancelAnimationFrame(raf);
            ro.disconnect(); io.disconnect();
            renderer.dispose();
            canvas.remove(); pinLayer.remove();
        },
    };
}

// ── Scroll walkthrough ────────────────────────────────────────────────────
// One camera stop per tour chapter. pos/look are world points, dusk is the
// lighting at that stop (the tour moves from late afternoon into dusk as
// visitors reach the pool), fov widens for eye-level shots. The interior
// stops sit at the patio doors: the page crossfades to the real interior
// photos there, since the model has no rooms inside.
const WALK = {
    arrive:   { pos: [-96, 36, 98],   look: [2, 0, -6],     dusk: 0.38, fov: 38 },
    drive:    { pos: [-44, 4.2, 38],  look: [-36, 1.5, -6], dusk: 0.45, fov: 50 },
    court:    { pos: [-38, 6.5, 13],  look: [-20, 0, -3],   dusk: 0.55, fov: 48 },
    lawn:     { pos: [-13, 3.2, 31],  look: [-3, 0.5, 6],   dusk: 0.7,  fov: 52 },
    pool:     { pos: [2, 3.6, 11],    look: [11, 0, -6],    dusk: 0.92, fov: 52 },
    pavilion: { pos: [15, 2.3, 7],    look: [24, 1.4, -3],  dusk: 1,    fov: 54 },
    kitchen:  { pos: [10, 2.2, -5],   look: [15, 1.6, -19], dusk: 1,    fov: 54 },
    living:   { pos: [4, 2, -8],      look: [1.5, 2, -16],  dusk: 1,    fov: 50 },
    dining:   { pos: [3, 2, -9.4],    look: [0, 2, -16],    dusk: 1,    fov: 50 },
    bedrooms: { pos: [1, 5.6, -9.2],  look: [-3, 5.4, -16], dusk: 1,    fov: 50 },
    game:     { pos: [-7.5, 2, -8.6], look: [-9, 2, -16],   dusk: 1,    fov: 50 },
    golf:     { pos: [46, 24, 102],   look: [65, 0, 64],    dusk: 1,    fov: 44 },
    finale:   { pos: [-84, 40, 104],  look: [2, 0, -6],     dusk: 1,    fov: 38 },
};

export function mountEstateWalk(stage, options = {}) {
    const reducedMotion = !!options.reducedMotion;
    const { renderer, scene, camera, applyLighting, waterUniforms, warmUp } = createWorld(stage, options);
    const keys = (options.chapters || Object.keys(WALK)).map(id => WALK[id] || WALK.arrive);
    const last = keys.length - 1;
    const curve = (pick) => new THREE.CatmullRomCurve3(keys.map(k => new THREE.Vector3(...pick(k))), false, 'centripetal');
    const posCurve = curve(k => k.pos), lookCurve = curve(k => k.look);
    const smootherstep = x => x * x * x * (x * (x * 6 - 15) + 10);

    let target = 0, current = 0, dusk = -1, time = 0;
    let width = 0, height = 0, running = true, visible = true, raf = 0, lastNow = performance.now();
    const look = new THREE.Vector3();

    // Keep the subject clear of the chapter card: right of centre on wide
    // screens (card on the left), above centre on narrow ones (card below).
    function resize() {
        width = stage.clientWidth; height = stage.clientHeight;
        if (!width || !height) return;
        renderer.setSize(width, height, false);
        camera.aspect = width / height;
        const fx = width >= 992 ? 0.62 : 0.5, fy = width >= 992 ? 0.5 : 0.3;
        const fw = width * (1 + 2 * Math.abs(fx - 0.5)), fh = height * (1 + 2 * Math.abs(fy - 0.5));
        camera.setViewOffset(fw, fh, fx < 0.5 ? fw - width : 0, fy < 0.5 ? fh - height : 0, width, height);
    }
    const ro = new ResizeObserver(resize);
    ro.observe(stage);
    resize();

    function place(dt) {
        const k = Math.min(Math.max(current, 0), last);
        const seg = Math.min(Math.floor(k), Math.max(last - 1, 0));
        const f = k - seg;
        // Dwell at each stop while its card is readable, travel in between.
        const e = reducedMotion ? (f < 0.5 ? 0 : 1) : smootherstep(Math.min(Math.max((f - 0.2) / 0.6, 0), 1));
        const t = last ? (seg + e) / last : 0;
        const a = keys[seg], b = keys[Math.min(seg + 1, last)];
        posCurve.getPoint(t, camera.position);
        lookCurve.getPoint(t, look);
        // A gentle stride while moving at eye level.
        const speed = Math.min(Math.abs(target - current) * 4, 1);
        if (!reducedMotion && camera.position.y < 8) camera.position.y += Math.sin(time * 8) * 0.06 * speed;
        camera.fov = a.fov + (b.fov - a.fov) * e;
        camera.updateProjectionMatrix();
        camera.lookAt(look);
        const d = a.dusk + (b.dusk - a.dusk) * e;
        if (Math.abs(d - dusk) > 0.002) { dusk = d; applyLighting(d); }
    }

    function frame(now) {
        raf = 0;
        if (!running || !visible || document.hidden) return;
        const dt = Math.min((now - lastNow) / 1000, 0.05);
        lastNow = now;
        time += dt;
        waterUniforms.uTime.value += dt;
        current += (target - current) * (reducedMotion ? 1 : 1 - Math.exp(-dt * 3.2));
        if (Math.abs(target - current) < 0.0005) current = target;
        place(dt);
        renderer.render(scene, camera);
        raf = requestAnimationFrame(frame);
    }
    let ready = false;
    const kick = () => { if (ready && !raf && running && visible && !document.hidden) { lastNow = performance.now(); raf = requestAnimationFrame(frame); } };
    const io = new IntersectionObserver(entries => { visible = entries[0].isIntersecting; kick(); });
    io.observe(stage);
    document.addEventListener('visibilitychange', kick);
    renderer.domElement.addEventListener('webglcontextlost', e => { e.preventDefault(); running = false; options.onLost && options.onLost(); });

    target = current = Math.min(Math.max(options.progress || 0, 0), last);
    place(0);
    warmUp().then(() => {
        if (!running) return;
        ready = true;
        current = target;
        place(0);
        renderer.render(scene, camera);
        options.onReady && options.onReady();
        kick();
    });

    return {
        // k is the chapter position: 0 = first chapter, 1.5 = halfway between the second and third.
        setProgress(k) { target = Math.min(Math.max(k, 0), last); kick(); },
        destroy() {
            running = false;
            cancelAnimationFrame(raf);
            ro.disconnect(); io.disconnect();
            renderer.dispose();
            renderer.domElement.remove();
        },
    };
}
