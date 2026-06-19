<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Card — {{ $student->full_name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1e293b; font-size: 12px; line-height: 1.5; }
        .page { width: 100%; padding: 30px 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #2563eb; padding-bottom: 16px; margin-bottom: 20px; }
        .header-left h1 { font-size: 20px; color: #2563eb; font-weight: 800; }
        .header-left p { font-size: 11px; color: #64748b; margin-top: 2px; }
        .header-right { text-align: right; }
        .header-right .badge { display: inline-block; background: #2563eb; color: white; padding: 4px 14px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .header-right p { font-size: 10px; color: #94a3b8; margin-top: 4px; }

        .student-info { display: flex; gap: 20px; margin-bottom: 20px; }
        .info-card { flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px 14px; }
        .info-card label { display: block; font-size: 9px; text-transform: uppercase; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 2px; }
        .info-card span { font-size: 12px; font-weight: 600; color: #1e293b; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead th { background: #1e293b; color: white; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; padding: 8px 10px; text-align: left; }
        thead th.center { text-align: center; }
        tbody td { padding: 8px 10px; border-bottom: 1px solid #e2e8f0; font-size: 11px; }
        tbody td.center { text-align: center; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        .grade-badge { display: inline-block; width: 22px; height: 22px; line-height: 22px; text-align: center; border-radius: 4px; font-weight: 700; font-size: 10px; }
        .grade-A, .grade-B { background: #d1fae5; color: #065f46; }
        .grade-C { background: #dbeafe; color: #1e40af; }
        .grade-D, .grade-E { background: #fef3c7; color: #92400e; }
        .grade-F { background: #fee2e2; color: #991b1b; }

        .summary-section { display: flex; gap: 12px; margin-bottom: 20px; }
        .summary-box { flex: 1; border-radius: 6px; padding: 12px 14px; text-align: center; }
        .summary-box label { display: block; font-size: 9px; text-transform: uppercase; color: #94a3b8; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 4px; }
        .summary-box .value { font-size: 22px; font-weight: 800; }
        .summary-box.total { background: #eff6ff; border: 1px solid #bfdbfe; }
        .summary-box.total .value { color: #2563eb; }
        .summary-box.average { background: #f0fdf4; border: 1px solid #bbf7d0; }
        .summary-box.average .value { color: #059669; }
        .summary-box.position { background: #fef3c7; border: 1px solid #fde68a; }
        .summary-box.position .value { color: #d97706; }
        .summary-box.overall { background: #1e293b; border: 1px solid #1e293b; }
        .summary-box.overall .value { color: white; }
        .summary-box.overall label { color: #94a3b8; }

        .attendance-section { margin-bottom: 20px; }
        .attendance-section h3 { font-size: 12px; font-weight: 700; color: #1e293b; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.3px; }
        .attendance-row { display: flex; gap: 10px; }
        .attendance-item { flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 10px; text-align: center; }
        .attendance-item label { display: block; font-size: 9px; color: #64748b; text-transform: uppercase; font-weight: 600; }
        .attendance-item span { font-size: 14px; font-weight: 700; color: #1e293b; }

        .remarks-section { margin-bottom: 20px; }
        .remarks-section h3 { font-size: 12px; font-weight: 700; color: #1e293b; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.3px; }
        .remarks-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px 14px; font-size: 11px; color: #475569; min-height: 50px; }

        .footer { margin-top: 30px; padding-top: 16px; border-top: 2px solid #e2e8f0; display: flex; justify-content: space-between; }
        .signature { text-align: center; }
        .signature .line { width: 180px; border-top: 1px solid #475569; margin-bottom: 4px; }
        .signature p { font-size: 10px; color: #64748b; font-weight: 600; }

        .grading-key { margin-top: 16px; font-size: 9px; color: #94a3b8; text-align: center; }
        .grading-key span { margin: 0 8px; }
    </style>
</head>
<body>
    <div class="page">
        {{-- Header --}}
        <div class="header">
            <div class="header-left">
                <h1>{{ $student->school->name }}</h1>
                <p>{{ $student->school->address ?? 'Nigeria' }} · {{ $student->school->email ?? '' }}</p>
            </div>
            <div class="header-right">
                <span class="badge">REPORT CARD</span>
                <p>{{ $term->academicSession->name }} · {{ $term->name }}</p>
            </div>
        </div>

        {{-- Student Info --}}
        <div class="student-info">
            <div class="info-card">
                <div class="info-grid">
                    <div>
                        <label>Student Name</label>
                        <span>{{ $student->full_name }}</span>
                    </div>
                    <div>
                        <label>Class</label>
                        <span>{{ $student->schoolClass?->name ?? '—' }}</span>
                    </div>
                    <div>
                        <label>Section</label>
                        <span>{{ $student->section?->name ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grades Table --}}
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th class="center">CA (40)</th>
                    <th class="center">Exam (60)</th>
                    <th class="center">Total (100)</th>
                    <th class="center">Grade</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grades as $index => $grade)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $grade->subject->name }}</td>
                    <td class="center">{{ number_format($grade->ca_score, 2) }}</td>
                    <td class="center">{{ number_format($grade->exam_score, 2) }}</td>
                    <td class="center"><strong>{{ number_format($grade->total_score, 2) }}</strong></td>
                    <td class="center"><span class="grade-badge grade-{{ $grade->grade }}">{{ $grade->grade }}</span></td>
                    <td>{{ $grade->remarks ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px; color: #94a3b8;">No grades recorded for this term.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Summary --}}
        <div class="summary-section">
            <div class="summary-box total">
                <label>Total Score</label>
                <div class="value">{{ number_format($totalScore, 2) }}</div>
            </div>
            <div class="summary-box average">
                <label>Average</label>
                <div class="value">{{ number_format($average, 2) }}</div>
            </div>
            <div class="summary-box position">
                <label>Position in Class</label>
                <div class="value">{{ $position }}<span style="font-size: 12px; color: #94a3b8;">/{{ $totalStudents }}</span></div>
            </div>
            <div class="summary-box overall">
                <label>Overall Grade</label>
                <div class="value">{{ $overallGrade }}</div>
            </div>
        </div>

        {{-- Attendance --}}
        <div class="attendance-section">
            <h3>Attendance Summary</h3>
            <div class="attendance-row">
                <div class="attendance-item">
                    <label>Present</label>
                    <span>{{ $attendance['present'] ?? 0 }}</span>
                </div>
                <div class="attendance-item">
                    <label>Absent</label>
                    <span>{{ $attendance['absent'] ?? 0 }}</span>
                </div>
                <div class="attendance-item">
                    <label>Late</label>
                    <span>{{ $attendance['late'] ?? 0 }}</span>
                </div>
                <div class="attendance-item">
                    <label>Excused</label>
                    <span>{{ $attendance['excused'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        {{-- Remarks --}}
        <div class="remarks-section">
            <h3>Class Teacher's Remarks</h3>
            <div class="remarks-box">
                @if($average >= 70)
                    Excellent performance! Keep up the outstanding work.
                @elseif($average >= 60)
                    Very good performance. With a little more effort, you can achieve excellence.
                @elseif($average >= 50)
                    Good performance. There is room for improvement.
                @elseif($average >= 40)
                    Fair performance. You need to work harder next term.
                @else
                    Poor performance. Significant improvement is needed. Please seek extra help.
                @endif
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <div class="signature">
                <div class="line"></div>
                <p>Class Teacher's Signature</p>
            </div>
            <div class="signature">
                <div class="line"></div>
                <p>Principal's Signature & Stamp</p>
            </div>
        </div>

        <div class="grading-key">
            <strong>Grading Key:</strong>
            <span>A: 70-100 (Excellent)</span>
            <span>B: 60-69 (Very Good)</span>
            <span>C: 50-59 (Good)</span>
            <span>D: 45-49 (Fair)</span>
            <span>E: 40-44 (Pass)</span>
            <span>F: Below 40 (Fail)</span>
        </div>
    </div>
</body>
</html>
