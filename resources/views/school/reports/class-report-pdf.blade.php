<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Class Report — {{ $class->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1e293b; font-size: 11px; line-height: 1.4; }
        .page { width: 100%; padding: 25px 30px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #2563eb; padding-bottom: 12px; margin-bottom: 16px; }
        .header-left h1 { font-size: 18px; color: #2563eb; font-weight: 800; }
        .header-left p { font-size: 10px; color: #64748b; margin-top: 2px; }
        .header-right { text-align: right; }
        .header-right .badge { display: inline-block; background: #059669; color: white; padding: 4px 12px; border-radius: 4px; font-size: 10px; font-weight: 600; }
        .header-right p { font-size: 9px; color: #94a3b8; margin-top: 4px; }

        .class-info { display: flex; gap: 16px; margin-bottom: 16px; }
        .info-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 14px; }
        .info-item label { display: block; font-size: 8px; text-transform: uppercase; color: #94a3b8; font-weight: 600; }
        .info-item span { font-size: 11px; font-weight: 600; }

        table { width: 100%; border-collapse: collapse; }
        thead th { background: #1e293b; color: white; font-size: 9px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; padding: 7px 6px; text-align: center; }
        thead th.left { text-align: left; }
        tbody td { padding: 6px; border-bottom: 1px solid #e2e8f0; font-size: 10px; text-align: center; }
        tbody td.left { text-align: left; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .grade-badge { display: inline-block; width: 18px; height: 18px; line-height: 18px; text-align: center; border-radius: 3px; font-weight: 700; font-size: 9px; }
        .grade-A, .grade-B { background: #d1fae5; color: #065f46; }
        .grade-C { background: #dbeafe; color: #1e40af; }
        .grade-D, .grade-E { background: #fef3c7; color: #92400e; }
        .grade-F { background: #fee2e2; color: #991b1b; }

        .pos-1 { background: #fef3c7 !important; font-weight: 700; }
        .pos-2 { background: #f1f5f9 !important; font-weight: 700; }
        .pos-3 { background: #fefce8 !important; font-weight: 700; }

        .footer { margin-top: 20px; padding-top: 12px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; }
        .signature { text-align: center; }
        .signature .line { width: 160px; border-top: 1px solid #475569; margin-bottom: 4px; }
        .signature p { font-size: 9px; color: #64748b; font-weight: 600; }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div class="header-left">
                <h1>{{ $class->school->name ?? 'School' }}</h1>
                <p>Class Summary Report</p>
            </div>
            <div class="header-right">
                <span class="badge">{{ $class->name }}</span>
                <p>{{ $term->academicSession->name }} · {{ $term->name }}</p>
            </div>
        </div>

        <div class="class-info">
            <div class="info-item"><label>Class</label><span>{{ $class->name }}</span></div>
            <div class="info-item"><label>Term</label><span>{{ $term->name }}</span></div>
            <div class="info-item"><label>Session</label><span>{{ $term->academicSession->name }}</span></div>
            <div class="info-item"><label>Students</label><span>{{ count($studentResults) }}</span></div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">Pos</th>
                    <th class="left">Student Name</th>
                    @php($subjectCount = 0)
                    @foreach($studentResults[0]['grades'] ?? [] as $grade)
                        <th>{{ $grade->subject->code ?? substr($grade->subject->name, 0, 4) }}</th>
                        @php($subjectCount++)
                    @endforeach
                    <th>Total</th>
                    <th>Avg</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentResults as $result)
                <tr class="{{ $result['position'] <= 3 ? 'pos-' . $result['position'] : '' }}">
                    <td><strong>{{ $result['position'] }}</strong></td>
                    <td class="left"><strong>{{ $result['student']->full_name }}</strong></td>
                    @foreach($result['grades'] as $grade)
                    <td>{{ number_format($grade->total_score, 0) }}</td>
                    @endforeach
                    @if(empty($result['grades']))
                        @for($i = 0; $i < max(1, $subjectCount); $i++)<td>—</td>@endfor
                    @endif
                    <td><strong>{{ number_format($result['total'], 0) }}</strong></td>
                    <td><strong>{{ number_format($result['average'], 1) }}</strong></td>
                    <td><span class="grade-badge grade-{{ $result['grade'] }}">{{ $result['grade'] }}</span></td>
                </tr>
                @endforeach
                @if(empty($studentResults))
                <tr>
                    <td colspan="{{ 4 + max(1, $subjectCount) }}" style="text-align: center; padding: 30px; color: #94a3b8;">
                        No grades recorded for this class in the selected term.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="footer">
            <div class="signature">
                <div class="line"></div>
                <p>Class Teacher</p>
            </div>
            <div class="signature">
                <div class="line"></div>
                <p>Principal</p>
            </div>
        </div>
    </div>
</body>
</html>
