<?php
/**
 * 게임 API
 * 슬롯머신, 룰렛 등 게임 처리
 */

include_once('./_common.php');

header('Content-Type: application/json; charset=utf-8');

// 로그인 체크
if (!$is_member) {
    echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$bet = isset($_POST['bet']) ? intval($_POST['bet']) : 0;

// 베팅 금액 검증 (베팅이 필요한 액션에만 적용)
$valid_bets = [10, 50, 100, 500, 1000, 5000, 10000];
$bet_required_actions = [
    'slot',
    'roulette',
    'dice',
    'blackjack_deal',
    'baccarat',
    'crash_bet',
    'btc_bet',
    // 아래 액션들은 프론트에서 bet을 보내는 경우가 있어도, 기본적으로 bet 검증/포인트 체크는 여기에서 처리
];
if (in_array($action, $bet_required_actions, true)) {
    if (!in_array($bet, $valid_bets, true)) {
        echo json_encode(['success' => false, 'message' => '유효하지 않은 베팅 금액입니다.']);
        exit;
    }

    $member_point = $member['mb_point'];
    if ($member_point < $bet) {
        echo json_encode(['success' => false, 'message' => '포인트가 부족합니다.']);
        exit;
    }
}

/**
 * 게임 로그 저장
 */
function saveGameLog($member, $game, $betType, $betAmount, $result, $winAmount, $profit, $detail = '') {
    global $g5;

    $sql = "INSERT INTO {$g5['write_prefix']}game_log
            (mb_id, mb_nick, gl_game, gl_bet_type, gl_bet_amount, gl_result, gl_win_amount, gl_profit, gl_detail, gl_datetime)
            VALUES (
                '".sql_escape_string($member['mb_id'])."',
                '".sql_escape_string($member['mb_nick'])."',
                '".sql_escape_string($game)."',
                '".sql_escape_string($betType)."',
                '".intval($betAmount)."',
                '".sql_escape_string($result)."',
                '".intval($winAmount)."',
                '".intval($profit)."',
                '".sql_escape_string($detail)."',
                '".G5_TIME_YMDHIS."'
            )";
    sql_query($sql);
}

switch ($action) {
    case 'slot':
        handleSlotGame($bet, $member);
        break;
    case 'roulette':
        handleRouletteGame($bet, $member);
        break;
    case 'dice':
        $betType = isset($_POST['betType']) ? $_POST['betType'] : '';
        handleDiceGame($bet, $betType, $member);
        break;
    case 'blackjack_deal':
        handleBlackjackDeal($bet, $member);
        break;
    case 'blackjack_hit':
        handleBlackjackHit($member);
        break;
    case 'blackjack_stand':
        handleBlackjackStand($member);
        break;
    case 'blackjack_double':
        handleBlackjackDouble($member);
        break;
    case 'blackjack_commit':
        handleBlackjackCommit($member);
        break;
    case 'baccarat':
        $betType = isset($_POST['betType']) ? $_POST['betType'] : '';
        handleBaccaratGame($bet, $betType, $member);
        break;
    case 'baccarat_commit':
        handleBaccaratCommit($member);
        break;
    case 'crash_bet':
        handleCrashBet($bet, $member);
        break;
    case 'crash_cashout':
        $multiplier = isset($_POST['multiplier']) ? floatval($_POST['multiplier']) : 1.00;
        $winAmount = isset($_POST['winAmount']) ? intval($_POST['winAmount']) : 0;
        handleCrashCashout($bet, $multiplier, $winAmount, $member);
        break;
    case 'btc_bet':
        $betType = isset($_POST['betType']) ? $_POST['betType'] : '';
        handleBtcBet($bet, $betType, $member);
        break;
    case 'btc_result':
        $isWin = isset($_POST['isWin']) ? intval($_POST['isWin']) : 0;
        $profit = isset($_POST['profit']) ? intval($_POST['profit']) : 0;
        handleBtcResult($bet, $isWin, $profit, $member);
        break;
    case 'get_point':
        echo json_encode(['success' => true, 'point' => $member['mb_point']]);
        break;
    case 'get_ladder_result':
        $round = isset($_REQUEST['round']) ? intval($_REQUEST['round']) : 0;
        handleGetLadderResult($round);
        break;
    case 'ladder_bet':
        $round = isset($_POST['round']) ? intval($_POST['round']) : 0;
        $start = isset($_POST['start']) ? $_POST['start'] : '';
        $oe = isset($_POST['oe']) ? $_POST['oe'] : '';
        $line = isset($_POST['line']) ? $_POST['line'] : '';
        $amount = isset($_POST['amount']) ? intval($_POST['amount']) : 0;
        handleLadderBet($round, $start, $oe, $line, $amount, $member);
        break;
    case 'racing_bet':
        $round = isset($_POST['round']) ? intval($_POST['round']) : 0;
        $bets_raw = isset($_POST['bets']) ? $_POST['bets'] : '';

        // 다양한 방식으로 JSON 파싱 시도
        $bets = null;

        // 1차: 그대로 파싱
        if (!empty($bets_raw) && is_string($bets_raw)) {
            $bets = json_decode($bets_raw, true);
        }

        // 2차: stripslashes 후 파싱
        if ($bets === null && !empty($bets_raw) && is_string($bets_raw)) {
            $bets = json_decode(stripslashes($bets_raw), true);
        }

        // 3차: urldecode 후 파싱
        if ($bets === null && !empty($bets_raw) && is_string($bets_raw)) {
            $bets = json_decode(urldecode($bets_raw), true);
        }

        // 4차: 이미 배열이면 그대로 사용
        if ($bets === null && isset($_POST['bets']) && is_array($_POST['bets'])) {
            $bets = $_POST['bets'];
        }

        // 파싱 실패시
        if ($bets === null || !is_array($bets) || empty($bets)) {
            echo json_encode(['success' => false, 'message' => '베팅 정보가 없습니다.']);
            exit;
        }

        handleRacingBet($round, $bets, $member);
        break;
    case 'racing_result':
        $round = isset($_POST['round']) ? intval($_POST['round']) : 0;
        $winner = isset($_POST['winner']) ? intval($_POST['winner']) : 0;
        handleRacingResult($round, $winner, $member);
        break;
    default:
        echo json_encode(['success' => false, 'message' => '잘못된 요청입니다.']);
        break;
}

/**
 * Provably Fair (커밋-리빌) - 블랙잭 커밋(서버 시드 해시) 제공
 */
function handleBlackjackCommit($member) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['blackjack_pf'])) {
        $serverSeed = bin2hex(random_bytes(32));
        $_SESSION['blackjack_pf'] = [
            'serverSeed' => $serverSeed,
            'serverSeedHash' => hash('sha256', $serverSeed),
            'nonce' => 0
        ];
    }

    echo json_encode([
        'success' => true,
        'provablyFair' => [
            'serverSeedHash' => $_SESSION['blackjack_pf']['serverSeedHash'],
            'nonce' => (int) $_SESSION['blackjack_pf']['nonce']
        ]
    ]);
}

/**
 * Provably Fair (커밋-리빌) - 바카라 커밋(서버 시드 해시) 제공
 */
function handleBaccaratCommit($member) {
    // 세션 시작
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['baccarat_pf'])) {
        $serverSeed = bin2hex(random_bytes(32));
        $_SESSION['baccarat_pf'] = [
            'serverSeed' => $serverSeed,
            'serverSeedHash' => hash('sha256', $serverSeed),
            'nonce' => 0
        ];
    }

    echo json_encode([
        'success' => true,
        'provablyFair' => [
            'serverSeedHash' => $_SESSION['baccarat_pf']['serverSeedHash'],
            'nonce' => (int) $_SESSION['baccarat_pf']['nonce']
        ]
    ]);
}

/**
 * Provably Fair - 시드 기반 결정적 덱 생성 (Fisher-Yates + HMAC-SHA256)
 */
function createProvablyFairDeck($serverSeed, $clientSeed, $nonce) {
    $suits = ['♠', '♥', '♦', '♣'];
    $values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    $deck = [];

    foreach ($suits as $suit) {
        foreach ($values as $value) {
            $deck[] = ['suit' => $suit, 'value' => $value];
        }
    }

    $n = count($deck);
    // Fisher-Yates shuffle (i from n-1 downto 1)
    for ($i = $n - 1; $i > 0; $i--) {
        // deterministic random int in [0, i]
        $msg = $clientSeed . ':' . $nonce . ':' . $i;
        $hashBin = hash_hmac('sha256', $msg, $serverSeed, true);
        $u = unpack('N', substr($hashBin, 0, 4));
        $rand = $u ? (int) $u[1] : 0;
        $j = $rand % ($i + 1);

        $tmp = $deck[$i];
        $deck[$i] = $deck[$j];
        $deck[$j] = $tmp;
    }

    return $deck;
}

/**
 * 가중치 기반 랜덤 심볼 선택
 */
function getRandomSymbol($weights) {
    $totalWeight = array_sum($weights);
    $random = mt_rand(1, $totalWeight);
    $cumulative = 0;

    foreach ($weights as $symbol => $weight) {
        $cumulative += $weight;
        if ($random <= $cumulative) {
            return $symbol;
        }
    }
    return array_keys($weights)[0];
}

/**
 * 슬롯머신 게임 처리
 */
function handleSlotGame($bet, $member) {
    global $g5;

    // 심볼 배당률 (3개 일치 시)
    $multipliers = [
        '🍇' => 2,
        '🍋' => 3,
        '🍒' => 4,
        '🍀' => 5,
        '⭐' => 10,
        '💎' => 25,
        '7️⃣' => 100
    ];

    // 심볼 확률 (가중치)
    $weights = [
        '🍇' => 30,
        '🍋' => 25,
        '🍒' => 20,
        '🍀' => 12,
        '⭐' => 8,
        '💎' => 4,
        '7️⃣' => 1
    ];

    // 3개의 릴 결과 생성
    $reels = [];
    for ($i = 0; $i < 3; $i++) {
        $reels[] = getRandomSymbol($weights);
    }

    // 당첨 확인
    $isWin = false;
    $winAmount = 0;
    $winType = '';

    // 3개 모두 같으면 당첨
    if ($reels[0] === $reels[1] && $reels[1] === $reels[2]) {
        $isWin = true;
        $winAmount = $bet * $multipliers[$reels[0]];

        if ($reels[0] === '7️⃣') {
            $winType = 'jackpot';
        } else if ($reels[0] === '💎') {
            $winType = 'big';
        } else {
            $winType = 'normal';
        }
    }
    // 2개 같으면 소액 당첨 (베팅금의 1.5배 지급 = 순이익 50%)
    else if ($reels[0] === $reels[1] || $reels[1] === $reels[2] || $reels[0] === $reels[2]) {
        $isWin = true;
        $winAmount = intval($bet * 1.5); // 베팅금 + 50% 보너스
        $winType = 'small';
    }

    // 포인트 처리
    $pointChange = $isWin ? ($winAmount - $bet) : -$bet;
    $content = $isWin ? "슬롯머신 당첨 ({$winType})" : "슬롯머신 게임";

    insert_point($member['mb_id'], $pointChange, $content, 'game', $member['mb_id'], 'slot_' . time());

    // 게임 로그 저장 (이모지를 텍스트로 변환)
    $symbolNames = ['🍇'=>'포도', '🍋'=>'레몬', '🍒'=>'체리', '🍀'=>'클로버', '⭐'=>'별', '💎'=>'다이아', '7️⃣'=>'7'];
    $reelNames = array_map(function($r) use ($symbolNames) { return $symbolNames[$r] ?? $r; }, $reels);
    $detail = implode(' | ', $reelNames);
    saveGameLog($member, 'slot', $winType ?: 'lose', $bet, $isWin ? 'win' : 'lose', $winAmount, $pointChange, $detail);

    // 새 포인트 조회
    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'reels' => $reels,
        'win' => $isWin,
        'winType' => $winType,
        'winAmount' => $winAmount,
        'newPoint' => $new_member['mb_point']
    ]);
}

/**
 * 룰렛 게임 처리
 * 20칸 커스텀 룰렛: 꽝 8칸, 빨강(x2) 5칸, 검정(x2) 5칸, 초록(x14) 1칸, 골드(x7) 1칸
 */
function handleRouletteGame($bet, $member) {
    global $g5;

    // 휠 데이터 (프론트엔드와 동일)
    $wheelData = [
        ['label' => '꽝', 'type' => 'lose', 'multiplier' => 0],
        ['label' => 'x2', 'type' => 'red', 'multiplier' => 2],
        ['label' => '꽝', 'type' => 'lose', 'multiplier' => 0],
        ['label' => 'x2', 'type' => 'black', 'multiplier' => 2],
        ['label' => '꽝', 'type' => 'lose', 'multiplier' => 0],
        ['label' => 'x2', 'type' => 'red', 'multiplier' => 2],
        ['label' => '꽝', 'type' => 'lose', 'multiplier' => 0],
        ['label' => 'x2', 'type' => 'black', 'multiplier' => 2],
        ['label' => '꽝', 'type' => 'lose', 'multiplier' => 0],
        ['label' => 'x14', 'type' => 'green', 'multiplier' => 14],
        ['label' => '꽝', 'type' => 'lose', 'multiplier' => 0],
        ['label' => 'x2', 'type' => 'red', 'multiplier' => 2],
        ['label' => '꽝', 'type' => 'lose', 'multiplier' => 0],
        ['label' => 'x2', 'type' => 'black', 'multiplier' => 2],
        ['label' => '꽝', 'type' => 'lose', 'multiplier' => 0],
        ['label' => 'x2', 'type' => 'red', 'multiplier' => 2],
        ['label' => 'x7', 'type' => 'gold', 'multiplier' => 7],
        ['label' => 'x2', 'type' => 'black', 'multiplier' => 2],
        ['label' => 'x2', 'type' => 'red', 'multiplier' => 2],
        ['label' => 'x2', 'type' => 'black', 'multiplier' => 2]
    ];

    // 0~19 랜덤 슬롯 선택
    $result = mt_rand(0, 19);
    $slot = $wheelData[$result];

    $isWin = $slot['type'] !== 'lose';
    $multiplier = $slot['multiplier'];
    $winAmount = $isWin ? $bet * $multiplier : 0;

    // 포인트 처리
    // 당첨 시: 순이익 = 배당금 - 베팅금
    // 꽝: -베팅금
    $netProfit = $isWin ? ($winAmount - $bet) : -$bet;
    $content = $isWin ? "룰렛 당첨 ({$slot['label']}, +{$winAmount}P)" : "룰렛 꽝";

    insert_point($member['mb_id'], $netProfit, $content, 'game', $member['mb_id'], 'roulette_' . time());

    // 게임 로그 저장
    saveGameLog($member, 'roulette', $slot['type'], $bet, $isWin ? 'win' : 'lose', $winAmount, $netProfit, $slot['label']);

    // 새 포인트 조회
    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'result' => $result,             // 슬롯 인덱스 (0~19)
        'label' => $slot['label'],       // 라벨 (꽝, x2, x7, x14)
        'type' => $slot['type'],         // 타입 (lose, red, black, green, gold)
        'win' => $isWin,
        'winAmount' => $winAmount,
        'netProfit' => $netProfit,
        'bet' => $bet,
        'newPoint' => $new_member['mb_point']
    ]);
}

/**
 * 주사위 (Hi-Lo) 게임 처리
 * LOW(2-6): x2, HIGH(8-12): x2, SEVEN: x5
 */
function handleDiceGame($bet, $betType, $member) {
    global $g5;

    // 베팅 타입 검증
    $validBetTypes = ['low', 'seven', 'high'];
    if (!in_array($betType, $validBetTypes)) {
        echo json_encode(['success' => false, 'message' => '유효하지 않은 베팅 타입입니다.']);
        return;
    }

    // 주사위 2개 굴리기
    $dice1 = mt_rand(1, 6);
    $dice2 = mt_rand(1, 6);
    $total = $dice1 + $dice2;

    // 결과 판정
    $resultType = '';
    if ($total >= 2 && $total <= 6) {
        $resultType = 'low';
    } else if ($total == 7) {
        $resultType = 'seven';
    } else {
        $resultType = 'high';
    }

    // 당첨 여부 및 배당
    $isWin = ($betType === $resultType);
    $multiplier = ($betType === 'seven') ? 5 : 2;
    $winAmount = $isWin ? $bet * $multiplier : 0;

    // 포인트 처리
    $netProfit = $isWin ? ($winAmount - $bet) : -$bet;
    $betLabel = ['low' => 'LOW', 'seven' => 'SEVEN', 'high' => 'HIGH'][$betType];
    $content = $isWin ? "주사위 당첨 ({$betLabel}, x{$multiplier})" : "주사위 게임 ({$betLabel})";

    insert_point($member['mb_id'], $netProfit, $content, 'game', $member['mb_id'], 'dice_' . time());

    // 게임 로그 저장
    $detail = "주사위: {$dice1}+{$dice2}={$total}";
    saveGameLog($member, 'dice', $betType, $bet, $isWin ? 'win' : 'lose', $winAmount, $netProfit, $detail);

    // 새 포인트 조회
    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'dice1' => $dice1,
        'dice2' => $dice2,
        'total' => $total,
        'resultType' => $resultType,
        'betType' => $betType,
        'win' => $isWin,
        'multiplier' => $multiplier,
        'winAmount' => $winAmount,
        'netProfit' => $netProfit,
        'newPoint' => $new_member['mb_point']
    ]);
}

/**
 * 블랙잭 - 카드 덱 생성
 */
function createDeck() {
    $suits = ['♠', '♥', '♦', '♣'];
    $values = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    $deck = [];

    foreach ($suits as $suit) {
        foreach ($values as $value) {
            $deck[] = ['suit' => $suit, 'value' => $value];
        }
    }

    shuffle($deck);
    return $deck;
}

/**
 * 블랙잭 - 핸드 점수 계산
 */
function calculateHandScore($hand) {
    $score = 0;
    $aces = 0;

    foreach ($hand as $card) {
        $value = $card['value'];
        if ($value === 'A') {
            $aces++;
            $score += 11;
        } else if (in_array($value, ['K', 'Q', 'J'])) {
            $score += 10;
        } else {
            $score += intval($value);
        }
    }

    // Ace 조정 (21 초과 시 11을 1로)
    while ($score > 21 && $aces > 0) {
        $score -= 10;
        $aces--;
    }

    return $score;
}

/**
 * 블랙잭 - 게임 시작 (딜)
 */
function handleBlackjackDeal($bet, $member) {
    global $g5;

    // 세션 시작
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Provably Fair 입력값 (클라이언트 시드/커밋 해시/논스)
    $clientSeed = isset($_POST['clientSeed']) ? trim((string)$_POST['clientSeed']) : '';
    $serverSeedHashFromClient = isset($_POST['serverSeedHash']) ? trim((string)$_POST['serverSeedHash']) : '';
    $nonceFromClient = isset($_POST['nonce']) ? intval($_POST['nonce']) : null;

    if ($clientSeed === '' || $serverSeedHashFromClient === '' || $nonceFromClient === null) {
        echo json_encode(['success' => false, 'message' => '검증 정보(clientSeed/serverSeedHash/nonce)가 누락되었습니다. 새로고침 후 다시 시도해 주세요.']);
        return;
    }

    if (!isset($_SESSION['blackjack_pf'])) {
        $serverSeed = bin2hex(random_bytes(32));
        $_SESSION['blackjack_pf'] = [
            'serverSeed' => $serverSeed,
            'serverSeedHash' => hash('sha256', $serverSeed),
            'nonce' => 0
        ];
    }

    if ($serverSeedHashFromClient !== $_SESSION['blackjack_pf']['serverSeedHash'] || $nonceFromClient !== (int)$_SESSION['blackjack_pf']['nonce']) {
        echo json_encode([
            'success' => false,
            'message' => '검증 정보가 서버 상태와 일치하지 않습니다. 해시 새로고침 후 다시 시도해 주세요.',
            'provablyFair' => [
                'serverSeedHash' => $_SESSION['blackjack_pf']['serverSeedHash'],
                'nonce' => (int) $_SESSION['blackjack_pf']['nonce']
            ]
        ]);
        return;
    }

    $serverSeed = (string)$_SESSION['blackjack_pf']['serverSeed'];
    $serverSeedHash = (string)$_SESSION['blackjack_pf']['serverSeedHash'];
    $nonce = (int)$_SESSION['blackjack_pf']['nonce'];

    // 덱 생성(시드 기반 결정적 셔플)
    $fullDeck = createProvablyFairDeck($serverSeed, $clientSeed, $nonce);

    // 초기 카드 배분
    $playerHand = [$fullDeck[0], $fullDeck[2]];
    $dealerHand = [$fullDeck[1], $fullDeck[3]];
    $deck = array_slice($fullDeck, 4);

    $playerScore = calculateHandScore($playerHand);
    $dealerScore = calculateHandScore($dealerHand);

    // 플레이어 블랙잭 체크
    $playerBlackjack = ($playerScore === 21);
    $dealerBlackjack = ($dealerScore === 21);

    // 게임 상태 저장
    $_SESSION['blackjack'] = [
        'deck' => $deck,
        'playerHand' => $playerHand,
        'dealerHand' => $dealerHand,
        'bet' => $bet,
        'status' => 'playing',
        'mb_id' => $member['mb_id'],
        'pf' => [
            'serverSeedHash' => $serverSeedHash,
            'serverSeed' => $serverSeed,
            'clientSeed' => $clientSeed,
            'nonce' => $nonce
        ],
        'drawLog' => [
            ['who' => 'player', 'card' => $playerHand[0]],
            ['who' => 'dealer', 'card' => $dealerHand[0]],
            ['who' => 'player', 'card' => $playerHand[1]],
            ['who' => 'dealer', 'card' => $dealerHand[1]],
        ]
    ];

    // 즉시 결과 처리 (둘 다 블랙잭 또는 플레이어만 블랙잭)
    if ($playerBlackjack || $dealerBlackjack) {
        return finishBlackjackGame($member, $playerBlackjack, $dealerBlackjack);
    }

    echo json_encode([
        'success' => true,
        'playerHand' => $playerHand,
        // 딜러는 첫 카드 공개, 두번째 카드 숨김 (프론트 표시 규칙과 일치)
        'dealerHand' => [$dealerHand[0], ['suit' => '?', 'value' => '?']],
        'playerScore' => $playerScore,
        'dealerScore' => '?',
        'status' => 'playing',
        'canDouble' => count($playerHand) === 2,
        'provablyFair' => [
            'serverSeedHash' => $serverSeedHash,
            'clientSeed' => $clientSeed,
            'nonce' => $nonce
        ]
    ]);
}

/**
 * 블랙잭 - 히트 (카드 추가)
 */
function handleBlackjackHit($member) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['blackjack']) || $_SESSION['blackjack']['status'] !== 'playing') {
        echo json_encode(['success' => false, 'message' => '진행 중인 게임이 없습니다.']);
        return;
    }

    $game = &$_SESSION['blackjack'];

    // 카드 한 장 추가
    $newCard = array_shift($game['deck']);
    $game['playerHand'][] = $newCard;
    if (!isset($game['drawLog']) || !is_array($game['drawLog'])) $game['drawLog'] = [];
    $game['drawLog'][] = ['who' => 'player', 'card' => $newCard];

    $playerScore = calculateHandScore($game['playerHand']);

    // 버스트 체크
    if ($playerScore > 21) {
        $game['status'] = 'bust';
        return finishBlackjackGame($member, false, false, true);
    }

    echo json_encode([
        'success' => true,
        'playerHand' => $game['playerHand'],
        'dealerHand' => [$game['dealerHand'][0], ['suit' => '?', 'value' => '?']],
        'playerScore' => $playerScore,
        'dealerScore' => '?',
        'status' => 'playing',
        'canDouble' => false,
        'provablyFair' => isset($game['pf']) ? [
            'serverSeedHash' => $game['pf']['serverSeedHash'],
            'clientSeed' => $game['pf']['clientSeed'],
            'nonce' => (int) $game['pf']['nonce']
        ] : null
    ]);
}

/**
 * 블랙잭 - 스탠드 (카드 그만 받기)
 */
function handleBlackjackStand($member) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['blackjack']) || $_SESSION['blackjack']['status'] !== 'playing') {
        echo json_encode(['success' => false, 'message' => '진행 중인 게임이 없습니다.']);
        return;
    }

    $game = &$_SESSION['blackjack'];

    // 딜러 턴 - 17 이상 될 때까지 카드 추가
    while (calculateHandScore($game['dealerHand']) < 17) {
        $card = array_shift($game['deck']);
        $game['dealerHand'][] = $card;
        if (!isset($game['drawLog']) || !is_array($game['drawLog'])) $game['drawLog'] = [];
        $game['drawLog'][] = ['who' => 'dealer', 'card' => $card];
    }

    return finishBlackjackGame($member, false, false, false);
}

/**
 * 블랙잭 - 더블다운 (베팅 2배 + 카드 1장만)
 */
function handleBlackjackDouble($member) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['blackjack']) || $_SESSION['blackjack']['status'] !== 'playing') {
        echo json_encode(['success' => false, 'message' => '진행 중인 게임이 없습니다.']);
        return;
    }

    $game = &$_SESSION['blackjack'];

    // 초기 2장일 때만 가능
    if (count($game['playerHand']) !== 2) {
        echo json_encode(['success' => false, 'message' => '더블다운은 처음 2장일 때만 가능합니다.']);
        return;
    }

    // 포인트 확인
    $member_point = $member['mb_point'];
    // 더블다운 시 최대 손실이 2배가 되므로, 최소 2배 베팅을 감당할 포인트가 있어야 함
    if ($member_point < ($game['bet'] * 2)) {
        echo json_encode(['success' => false, 'message' => '더블다운할 포인트가 부족합니다.']);
        return;
    }

    // 베팅 2배
    $game['bet'] *= 2;
    $game['doubled'] = true;

    // 카드 1장만 받고 스탠드
    $card = array_shift($game['deck']);
    $game['playerHand'][] = $card;
    if (!isset($game['drawLog']) || !is_array($game['drawLog'])) $game['drawLog'] = [];
    $game['drawLog'][] = ['who' => 'player', 'card' => $card];

    $playerScore = calculateHandScore($game['playerHand']);

    // 버스트 체크
    if ($playerScore > 21) {
        return finishBlackjackGame($member, false, false, true);
    }

    // 딜러 턴
    while (calculateHandScore($game['dealerHand']) < 17) {
        $dcard = array_shift($game['deck']);
        $game['dealerHand'][] = $dcard;
        $game['drawLog'][] = ['who' => 'dealer', 'card' => $dcard];
    }

    return finishBlackjackGame($member, false, false, false);
}

/**
 * 블랙잭 - 게임 종료 및 정산
 */
function finishBlackjackGame($member, $playerBlackjack, $dealerBlackjack, $playerBust = false) {
    $game = $_SESSION['blackjack'];
    $bet = $game['bet'];
    $playerHand = $game['playerHand'];
    $dealerHand = $game['dealerHand'];

    $playerScore = calculateHandScore($playerHand);
    $dealerScore = calculateHandScore($dealerHand);

    $result = '';
    $winAmount = 0;
    $loseAmount = 0;
    $netProfit = 0;

    if ($playerBust) {
        // 플레이어 버스트
        $result = 'bust';
        $loseAmount = $bet;
        $netProfit = -$bet;
    } else if ($playerBlackjack && $dealerBlackjack) {
        // 둘 다 블랙잭 - 푸시
        $result = 'push';
        $netProfit = 0;
    } else if ($playerBlackjack) {
        // 플레이어 블랙잭 - 2.5배
        $result = 'blackjack';
        $winAmount = intval($bet * 2.5);
        $netProfit = $winAmount - $bet;
    } else if ($dealerBlackjack) {
        // 딜러 블랙잭
        $result = 'dealer_blackjack';
        $loseAmount = $bet;
        $netProfit = -$bet;
    } else if ($dealerScore > 21) {
        // 딜러 버스트
        $result = 'dealer_bust';
        $winAmount = $bet * 2;
        $netProfit = $bet;
    } else if ($playerScore > $dealerScore) {
        // 플레이어 승
        $result = 'win';
        $winAmount = $bet * 2;
        $netProfit = $bet;
    } else if ($playerScore < $dealerScore) {
        // 딜러 승
        $result = 'lose';
        $loseAmount = $bet;
        $netProfit = -$bet;
    } else {
        // 무승부
        $result = 'push';
        $netProfit = 0;
    }

    // 포인트 처리
    if ($netProfit !== 0) {
        $content = "블랙잭 " . ($netProfit > 0 ? "승리" : "패배") . " ({$result})";
        insert_point($member['mb_id'], $netProfit, $content, 'game', $member['mb_id'], 'blackjack_' . time());
    }

    // 게임 로그 저장
    $detail = "Player:{$playerScore} vs Dealer:{$dealerScore}";
    saveGameLog($member, 'blackjack', $result, $bet, $netProfit >= 0 ? 'win' : 'lose', $winAmount, $netProfit, $detail);

    // 세션 정리
    unset($_SESSION['blackjack']);

    // 새 포인트 조회
    $new_member = get_member($member['mb_id']);

    // Provably Fair 리빌 + 다음 커밋 생성
    $pf = isset($game['pf']) ? $game['pf'] : null;
    $drawLog = isset($game['drawLog']) ? $game['drawLog'] : [];
    $nextCommit = null;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $nextServerSeed = bin2hex(random_bytes(32));
    $nextServerSeedHash = hash('sha256', $nextServerSeed);
    if (isset($_SESSION['blackjack_pf']) && $pf) {
        $nextNonce = ((int)$_SESSION['blackjack_pf']['nonce']) + 1;
        $_SESSION['blackjack_pf'] = [
            'serverSeed' => $nextServerSeed,
            'serverSeedHash' => $nextServerSeedHash,
            'nonce' => $nextNonce
        ];
        $nextCommit = ['nextServerSeedHash' => $nextServerSeedHash, 'nextNonce' => $nextNonce];
    }

    echo json_encode([
        'success' => true,
        'playerHand' => $playerHand,
        'dealerHand' => $dealerHand,
        'playerScore' => $playerScore,
        'dealerScore' => $dealerScore,
        'result' => $result,
        'winAmount' => $winAmount,
        'loseAmount' => $loseAmount,
        'netProfit' => $netProfit,
        'bet' => $bet,
        'status' => 'finished',
        'newPoint' => $new_member['mb_point'],
        'drawLog' => $drawLog,
        'provablyFair' => $pf ? array_merge([
            'serverSeedHash' => $pf['serverSeedHash'],
            'serverSeed' => $pf['serverSeed'],
            'clientSeed' => $pf['clientSeed'],
            'nonce' => (int)$pf['nonce'],
        ], $nextCommit ? $nextCommit : []) : null
    ]);
}

/**
 * 바카라 게임 처리
 * Player: x2, Banker: x1.95 (5% 커미션), Tie: x8
 */
function handleBaccaratGame($bet, $betType, $member) {
    global $g5;

    // 세션 시작 (Provably Fair 상태 저장용)
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Provably Fair 입력값 (클라이언트 시드/커밋 해시/논스)
    $clientSeed = isset($_POST['clientSeed']) ? trim((string)$_POST['clientSeed']) : '';
    $serverSeedHashFromClient = isset($_POST['serverSeedHash']) ? trim((string)$_POST['serverSeedHash']) : '';
    $nonceFromClient = isset($_POST['nonce']) ? intval($_POST['nonce']) : null;

    if ($clientSeed === '' || $serverSeedHashFromClient === '' || $nonceFromClient === null) {
        echo json_encode(['success' => false, 'message' => '검증 정보(clientSeed/serverSeedHash/nonce)가 누락되었습니다. 새로고침 후 다시 시도해 주세요.']);
        return;
    }

    // 서버 커밋 상태가 없으면 생성 (안전장치)
    if (!isset($_SESSION['baccarat_pf'])) {
        $serverSeed = bin2hex(random_bytes(32));
        $_SESSION['baccarat_pf'] = [
            'serverSeed' => $serverSeed,
            'serverSeedHash' => hash('sha256', $serverSeed),
            'nonce' => 0
        ];
    }

    // 클라이언트가 보고 있는 커밋/논스와 서버 상태 일치 검증
    if ($serverSeedHashFromClient !== $_SESSION['baccarat_pf']['serverSeedHash'] || $nonceFromClient !== (int)$_SESSION['baccarat_pf']['nonce']) {
        echo json_encode([
            'success' => false,
            'message' => '검증 정보가 서버 상태와 일치하지 않습니다. 새로고침 후 다시 시도해 주세요.',
            'provablyFair' => [
                'serverSeedHash' => $_SESSION['baccarat_pf']['serverSeedHash'],
                'nonce' => (int)$_SESSION['baccarat_pf']['nonce']
            ]
        ]);
        return;
    }

    // 베팅 타입 검증
    $validBetTypes = ['player', 'banker', 'tie'];
    if (!in_array($betType, $validBetTypes)) {
        echo json_encode(['success' => false, 'message' => '유효하지 않은 베팅 타입입니다.']);
        return;
    }

    // 덱 생성
    $serverSeed = (string)$_SESSION['baccarat_pf']['serverSeed'];
    $serverSeedHash = (string)$_SESSION['baccarat_pf']['serverSeedHash'];
    $nonce = (int)$_SESSION['baccarat_pf']['nonce'];
    $deck = createProvablyFairDeck($serverSeed, $clientSeed, $nonce);

    // 초기 카드 배분 (플레이어 2장, 뱅커 2장)
    $playerCards = [$deck[0], $deck[2]];
    $bankerCards = [$deck[1], $deck[3]];
    $deckIndex = 4;

    // 점수 계산 함수 (바카라 규칙: 10, J, Q, K = 0점, A = 1점, 나머지 액면가)
    $calcBaccaratScore = function($cards) {
        $total = 0;
        foreach ($cards as $card) {
            $val = $card['value'];
            if (in_array($val, ['10', 'J', 'Q', 'K'])) {
                $total += 0;
            } else if ($val === 'A') {
                $total += 1;
            } else {
                $total += intval($val);
            }
        }
        return $total % 10;
    };

    $playerScore = $calcBaccaratScore($playerCards);
    $bankerScore = $calcBaccaratScore($bankerCards);

    $playerThirdCard = null;
    $bankerThirdCard = null;

    // 내추럴 체크 (8 또는 9)
    $isNatural = ($playerScore >= 8 || $bankerScore >= 8);

    if (!$isNatural) {
        // 플레이어 써드 카드 규칙
        if ($playerScore <= 5) {
            $playerThirdCard = $deck[$deckIndex++];
            $playerCards[] = $playerThirdCard;
            $playerScore = $calcBaccaratScore($playerCards);
        }

        // 뱅커 써드 카드 규칙
        $bankerDraws = false;
        if ($playerThirdCard === null) {
            // 플레이어가 스탠드한 경우
            $bankerDraws = ($bankerScore <= 5);
        } else {
            // 플레이어가 써드 카드를 받은 경우
            $pThirdValue = $playerThirdCard['value'];
            $pThird = in_array($pThirdValue, ['10', 'J', 'Q', 'K']) ? 0 : ($pThirdValue === 'A' ? 1 : intval($pThirdValue));

            if ($bankerScore <= 2) {
                $bankerDraws = true;
            } else if ($bankerScore == 3 && $pThird != 8) {
                $bankerDraws = true;
            } else if ($bankerScore == 4 && in_array($pThird, [2, 3, 4, 5, 6, 7])) {
                $bankerDraws = true;
            } else if ($bankerScore == 5 && in_array($pThird, [4, 5, 6, 7])) {
                $bankerDraws = true;
            } else if ($bankerScore == 6 && in_array($pThird, [6, 7])) {
                $bankerDraws = true;
            }
        }

        if ($bankerDraws) {
            $bankerThirdCard = $deck[$deckIndex++];
            $bankerCards[] = $bankerThirdCard;
            $bankerScore = $calcBaccaratScore($bankerCards);
        }
    }

    // 승자 판정
    $winner = '';
    if ($playerScore > $bankerScore) {
        $winner = 'player';
    } else if ($bankerScore > $playerScore) {
        $winner = 'banker';
    } else {
        $winner = 'tie';
    }

    // 당첨 계산
    $isWin = ($betType === $winner);
    $winAmount = 0;
    $multiplier = 0;

    if ($isWin) {
        if ($betType === 'player') {
            $multiplier = 2;
            $winAmount = $bet * 2;
        } else if ($betType === 'banker') {
            $multiplier = 1.95; // 5% 커미션
            $winAmount = intval($bet * 1.95);
        } else if ($betType === 'tie') {
            $multiplier = 8;
            $winAmount = $bet * 8;
        }
    }

    // 포인트 처리
    $netProfit = $isWin ? ($winAmount - $bet) : -$bet;
    $betLabel = ['player' => '플레이어', 'banker' => '뱅커', 'tie' => '타이'][$betType];
    $content = $isWin ? "바카라 당첨 ({$betLabel}, x{$multiplier})" : "바카라 게임 ({$betLabel})";

    insert_point($member['mb_id'], $netProfit, $content, 'game', $member['mb_id'], 'baccarat_' . time());

    // 게임 로그 저장
    $detail = "Player:{$playerScore} vs Banker:{$bankerScore}, Winner:{$winner}";
    saveGameLog($member, 'baccarat', $betType, $bet, $isWin ? 'win' : 'lose', $winAmount, $netProfit, $detail);

    // 새 포인트 조회
    $new_member = get_member($member['mb_id']);

    // 다음 라운드 커밋 생성(커밋-리빌)
    $nextServerSeed = bin2hex(random_bytes(32));
    $nextServerSeedHash = hash('sha256', $nextServerSeed);
    $_SESSION['baccarat_pf'] = [
        'serverSeed' => $nextServerSeed,
        'serverSeedHash' => $nextServerSeedHash,
        'nonce' => $nonce + 1
    ];

    echo json_encode([
        'success' => true,
        'playerCards' => $playerCards,
        'bankerCards' => $bankerCards,
        'playerScore' => $playerScore,
        'bankerScore' => $bankerScore,
        'winner' => $winner,
        'betType' => $betType,
        'win' => $isWin,
        'multiplier' => $multiplier,
        'winAmount' => $winAmount,
        'netProfit' => $netProfit,
        'newPoint' => $new_member['mb_point'],
        'provablyFair' => [
            // 이번 판(커밋된 시드로 계산 → 지금 공개)
            'serverSeedHash' => $serverSeedHash,
            'serverSeed' => $serverSeed,
            'clientSeed' => $clientSeed,
            'nonce' => $nonce,
            // 다음 판 커밋
            'nextServerSeedHash' => $nextServerSeedHash,
            'nextNonce' => $nonce + 1
        ]
    ]);
}

/**
 * Crash 게임 - 베팅
 */
function handleCrashBet($bet, $member) {
    // 베팅금 차감
    insert_point($member['mb_id'], -$bet, "Crash 게임 베팅", 'game', $member['mb_id'], 'crash_bet_' . time());

    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'newPoint' => $new_member['mb_point']
    ]);
}

/**
 * Crash 게임 - 캐시아웃
 */
function handleCrashCashout($bet, $multiplier, $winAmount, $member) {
    // 당첨금 지급
    $profit = $winAmount - $bet;
    $content = "Crash 캐시아웃 (x{$multiplier})";

    insert_point($member['mb_id'], $winAmount, $content, 'game', $member['mb_id'], 'crash_win_' . time());

    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'winAmount' => $winAmount,
        'profit' => $profit,
        'newPoint' => $new_member['mb_point']
    ]);
}

/**
 * BTC 예측 게임 - 베팅
 */
function handleBtcBet($bet, $betType, $member) {
    $validTypes = ['up', 'down'];
    if (!in_array($betType, $validTypes)) {
        echo json_encode(['success' => false, 'message' => '유효하지 않은 베팅입니다.']);
        return;
    }

    // 베팅금 차감
    $typeLabel = $betType === 'up' ? 'UP' : 'DOWN';
    insert_point($member['mb_id'], -$bet, "BTC 예측 베팅 ({$typeLabel})", 'game', $member['mb_id'], 'btc_bet_' . time());

    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'newPoint' => $new_member['mb_point']
    ]);
}

/**
 * BTC 예측 게임 - 결과 처리
 */
function handleBtcResult($bet, $isWin, $profit, $member) {
    $betType = isset($_POST['betType']) ? $_POST['betType'] : 'unknown';
    $lockPrice = isset($_POST['lockPrice']) ? floatval($_POST['lockPrice']) : 0;
    $endPrice = isset($_POST['endPrice']) ? floatval($_POST['endPrice']) : 0;
    $result = isset($_POST['result']) ? $_POST['result'] : 'unknown';

    $typeLabel = $betType === 'up' ? 'UP' : ($betType === 'down' ? 'DOWN' : $betType);
    $resultLabel = $result === 'up' ? 'UP' : ($result === 'down' ? 'DOWN' : $result);

    // 상세 정보: 베팅방향, 잠금가, 마감가, 결과방향
    $detail = "베팅:{$typeLabel}, 잠금:\${$lockPrice}, 마감:\${$endPrice}, 결과:{$resultLabel}";

    if ($isWin) {
        $winAmount = $bet + $profit;
        $content = "BTC 예측 당첨 ({$typeLabel}, +{$winAmount}P)";
        insert_point($member['mb_id'], $winAmount, $content, 'game', $member['mb_id'], 'btc_win_' . time());

        // 게임 로그 저장 (승리)
        saveGameLog($member, 'btc', $typeLabel, $bet, 'win', $winAmount, $profit, $detail);
    } else {
        // 게임 로그 저장 (패배)
        saveGameLog($member, 'btc', $typeLabel, $bet, 'lose', 0, -$bet, $detail);
    }

    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'newPoint' => $new_member['mb_point']
    ]);
}

/**
 * 경마 게임 - 베팅
 */
function handleRacingBet($round, $bets, $member) {
    global $g5;

    // 회차 검증
    $round_interval = 60;
    $current_time = time();
    $current_round = floor($current_time / $round_interval);

    if ($round != $current_round) {
        echo json_encode(['success' => false, 'message' => '유효하지 않은 회차입니다.']);
        return;
    }

    // 베팅 마감 검증 (10초 전)
    $round_end = ($current_round + 1) * $round_interval;
    $remaining = $round_end - $current_time;
    if ($remaining <= 10) {
        echo json_encode(['success' => false, 'message' => '베팅이 마감되었습니다.']);
        return;
    }

    // 베팅 데이터 검증
    if (empty($bets) || !is_array($bets)) {
        echo json_encode(['success' => false, 'message' => '베팅 정보가 없습니다.']);
        return;
    }

    // 총 베팅금 계산
    $totalBet = 0;
    foreach ($bets as $bet) {
        if (!isset($bet['horseId']) || !isset($bet['amount']) || !isset($bet['odds'])) {
            echo json_encode(['success' => false, 'message' => '잘못된 베팅 형식입니다.']);
            return;
        }

        $amount = intval($bet['amount']);
        if ($amount < 10 || $amount > 10000) {
            echo json_encode(['success' => false, 'message' => '베팅 금액은 10~10,000 포인트입니다.']);
            return;
        }

        $totalBet += $amount;
    }

    // 포인트 검증
    $member_point = $member['mb_point'];
    if ($member_point < $totalBet) {
        echo json_encode(['success' => false, 'message' => '포인트가 부족합니다.']);
        return;
    }

    // 말 이름 목록
    $horseNames = [
        1 => '번개',
        2 => '황금마',
        3 => '블루윈드',
        4 => '그린라이트',
        5 => '퍼플스타',
        6 => '다크호스'
    ];

    // 베팅금 차감
    $horseId = intval($bets[0]['horseId']);
    $odds = floatval($bets[0]['odds']);
    $horseName = isset($horseNames[$horseId]) ? $horseNames[$horseId] : "#{$horseId}";
    $content = "경마 {$round}회차 베팅 ({$horseName}, x{$odds})";
    insert_point($member['mb_id'], -$totalBet, $content, 'game', $member['mb_id'], 'racing_bet_' . $round . '_' . time());

    // 경마 베팅 테이블에 저장
    $sql = "INSERT INTO {$g5['write_prefix']}game_racing_bet
            (mb_id, mb_nick, rb_round, rb_horse_id, rb_horse_name, rb_amount, rb_odds, rb_status, rb_datetime)
            VALUES (
                '".sql_escape_string($member['mb_id'])."',
                '".sql_escape_string($member['mb_nick'])."',
                '{$round}',
                '{$horseId}',
                '".sql_escape_string($horseName)."',
                '{$totalBet}',
                '{$odds}',
                'pending',
                '".G5_TIME_YMDHIS."'
            )";
    sql_query($sql);

    // 게임 로그 저장
    $detail = "회차:{$round}, 선택:{$horseName}, 배당:x{$odds}";
    saveGameLog($member, 'racing', "horse_{$horseId}", $totalBet, 'pending', 0, 0, $detail);

    // 새 포인트 조회
    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'point' => $new_member['mb_point'],
        'message' => '베팅이 완료되었습니다.'
    ]);
}

/**
 * 경마 결과 처리 (레이스 종료 후 호출)
 */
function handleRacingResult($round, $winner, $member) {
    global $g5;

    // 회차 검증 (이전 회차만 처리 가능)
    $round_interval = 60;
    $current_time = time();
    $current_round = floor($current_time / $round_interval);

    if ($round >= $current_round) {
        echo json_encode(['success' => false, 'message' => '아직 진행 중인 회차입니다.']);
        return;
    }

    // 해당 유저의 해당 회차 pending 베팅 조회
    $sql = "SELECT * FROM {$g5['write_prefix']}game_racing_bet
            WHERE mb_id = '".sql_escape_string($member['mb_id'])."'
            AND rb_round = '{$round}'
            AND rb_status = 'pending'
            LIMIT 1";
    $bet = sql_fetch($sql);

    if (!$bet) {
        echo json_encode(['success' => false, 'message' => '처리할 베팅이 없습니다.']);
        return;
    }

    // 결과 판정
    $is_win = ($bet['rb_horse_id'] == $winner);
    $win_amount = 0;

    if ($is_win) {
        // 당첨: 베팅금 * 배당률
        $win_amount = floor($bet['rb_amount'] * $bet['rb_odds']);
        $content = "경마 {$round}회차 당첨 ({$bet['rb_horse_name']}, x{$bet['rb_odds']})";
        insert_point($member['mb_id'], $win_amount, $content, 'game', $member['mb_id'], 'racing_win_' . $round . '_' . $bet['rb_id']);

        // 베팅 상태 업데이트
        $update_sql = "UPDATE {$g5['write_prefix']}game_racing_bet
                       SET rb_status = 'win', rb_win_amount = '{$win_amount}'
                       WHERE rb_id = '{$bet['rb_id']}'";
        sql_query($update_sql);

        // 게임 로그 업데이트
        $detail = "회차:{$round}, 선택:{$bet['rb_horse_name']}, 배당:x{$bet['rb_odds']}, 당첨:{$win_amount}P";
        saveGameLog($member, 'racing', "horse_{$bet['rb_horse_id']}", $bet['rb_amount'], 'win', $win_amount, $win_amount - $bet['rb_amount'], $detail);
    } else {
        // 낙첨
        $update_sql = "UPDATE {$g5['write_prefix']}game_racing_bet
                       SET rb_status = 'lose'
                       WHERE rb_id = '{$bet['rb_id']}'";
        sql_query($update_sql);

        $detail = "회차:{$round}, 선택:{$bet['rb_horse_name']}, 배당:x{$bet['rb_odds']}, 낙첨";
        saveGameLog($member, 'racing', "horse_{$bet['rb_horse_id']}", $bet['rb_amount'], 'lose', 0, -$bet['rb_amount'], $detail);
    }

    // 새 포인트 조회
    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'point' => $new_member['mb_point'],
        'is_win' => $is_win,
        'win_amount' => $win_amount,
        'message' => $is_win ? "축하합니다! {$win_amount}P 당첨!" : '아쉽게도 낙첨되었습니다.'
    ]);
}

/**
 * 사다리 게임 - 결과 조회
 */
function handleGetLadderResult($round) {
    $secret = 'speed_ladder_secret_2024';
    $hash = hash('sha256', $round . $secret);

    $start = hexdec(substr($hash, 0, 8)) % 2;
    $odd_even = hexdec(substr($hash, 8, 8)) % 2;
    $lines = (hexdec(substr($hash, 16, 8)) % 2) + 3;

    echo json_encode([
        'success' => true,
        'result' => [
            'start' => $start,
            'odd_even' => $odd_even,
            'lines' => $lines
        ]
    ]);
}

/**
 * 사다리 게임 - 베팅
 */
function handleLadderBet($round, $start, $oe, $line, $amount, $member) {
    global $g5;

    // 금액 검증
    if ($amount < 10 || $amount > 5000) {
        echo json_encode(['success' => false, 'message' => '베팅 금액은 10~5000P입니다.']);
        return;
    }

    // 베팅 항목 수
    $betCount = 0;
    if ($start !== '') $betCount++;
    if ($oe !== '') $betCount++;
    if ($line !== '') $betCount++;

    if ($betCount === 0) {
        echo json_encode(['success' => false, 'message' => '베팅 항목을 선택해주세요.']);
        return;
    }

    $totalBet = $amount * $betCount;

    // 포인트 검증
    if ($member['mb_point'] < $totalBet) {
        echo json_encode(['success' => false, 'message' => '포인트가 부족합니다.']);
        return;
    }

    // 회차 검증
    $round_interval = 30;
    $current_time = time();
    $current_round = floor($current_time / $round_interval);
    $round_end = ($current_round + 1) * $round_interval;
    $remaining = $round_end - $current_time;

    if ($round != $current_round) {
        echo json_encode(['success' => false, 'message' => '유효하지 않은 회차입니다.']);
        return;
    }

    if ($remaining <= 8) {
        echo json_encode(['success' => false, 'message' => '베팅이 마감되었습니다.']);
        return;
    }

    // 베팅 차감
    $betDesc = [];
    if ($start !== '') $betDesc[] = ($start == '0' ? '좌' : '우');
    if ($oe !== '') $betDesc[] = ($oe == '1' ? '홀' : '짝');
    if ($line !== '') $betDesc[] = "{$line}줄";

    $content = "사다리 베팅 (" . implode(', ', $betDesc) . ")";
    insert_point($member['mb_id'], -$totalBet, $content, 'game', $member['mb_id'], 'ladder_bet_' . $round . '_' . time());

    // DB에 베팅 저장
    $ladder_table = $g5['write_prefix'] . 'game_ladder_bet';
    $odds = 1.95;
    $now = date('Y-m-d H:i:s');

    // 베팅 정보 배열 (프론트엔드 반환용)
    $bets = [];

    if ($start !== '') {
        sql_query("INSERT INTO {$ladder_table} SET
            mb_id = '{$member['mb_id']}',
            mb_nick = '".addslashes($member['mb_nick'])."',
            lb_round = {$round},
            lb_bet_type = 'start',
            lb_bet_value = '{$start}',
            lb_amount = {$amount},
            lb_odds = {$odds},
            lb_status = 'pending',
            lb_datetime = '{$now}'");
        $bets[] = ['type' => 'start', 'value' => $start, 'amount' => $amount, 'odds' => $odds, 'round' => $round];
    }

    if ($oe !== '') {
        sql_query("INSERT INTO {$ladder_table} SET
            mb_id = '{$member['mb_id']}',
            mb_nick = '".addslashes($member['mb_nick'])."',
            lb_round = {$round},
            lb_bet_type = 'oe',
            lb_bet_value = '{$oe}',
            lb_amount = {$amount},
            lb_odds = {$odds},
            lb_status = 'pending',
            lb_datetime = '{$now}'");
        $bets[] = ['type' => 'oe', 'value' => $oe, 'amount' => $amount, 'odds' => $odds, 'round' => $round];
    }

    if ($line !== '') {
        sql_query("INSERT INTO {$ladder_table} SET
            mb_id = '{$member['mb_id']}',
            mb_nick = '".addslashes($member['mb_nick'])."',
            lb_round = {$round},
            lb_bet_type = 'line',
            lb_bet_value = '{$line}',
            lb_amount = {$amount},
            lb_odds = {$odds},
            lb_status = 'pending',
            lb_datetime = '{$now}'");
        $bets[] = ['type' => 'line', 'value' => $line, 'amount' => $amount, 'odds' => $odds, 'round' => $round];
    }

    // 새 포인트 조회
    $new_member = get_member($member['mb_id']);

    echo json_encode([
        'success' => true,
        'point' => $new_member['mb_point'],
        'bets' => $bets
    ]);
}
