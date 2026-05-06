<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\NoteModel;
use App\Models\MatiereModel;
use App\Models\ParcourModel;
use App\Models\SemestreModel;
use App\Models\MatiereParcourModel;

class NoteController extends BaseController
{
    private EtudiantModel $etudiantModel;
    private NoteModel $noteModel;
    private MatiereModel $matiereModel;
    private ParcourModel $parcourModel;
    private SemestreModel $semestreModel;
    private MatiereParcourModel $matiereParcourModel;

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
        $this->noteModel = new NoteModel();
        $this->matiereModel = new MatiereModel();
        $this->parcourModel = new ParcourModel();
        $this->semestreModel = new SemestreModel();
        $this->matiereParcourModel = new MatiereParcourModel();
    }

    public function index(){
        $matieresParcours = $this->matiereParcourModel->findAll();
        
        // Organiser les matières par parcours pour JavaScript
        $matieresByParcours = [];
        foreach ($matieresParcours as $mp) {
            $matiere = $this->matiereModel->find($mp['idMatiere']);
            if (!isset($matieresByParcours[$mp['idParcours']])) {
                $matieresByParcours[$mp['idParcours']] = [];
            }
            $matieresByParcours[$mp['idParcours']][] = [
                'idMatiere' => $mp['idMatiere'],
                'Nom' => $matiere['Nom'],
                'Credit' => $mp['Credit'],
                'estObligatoire' => $mp['estObligatoire'],
                'idSemestre' => $matiere['idSemestre']
            ];
        }
        
        // Organiser les parcours par semestre
        $parcoursBySemestre = [];
        // S3 = 1 (Tronc commun avec idParcours = 1)
        $parcoursBySemestre[1] = [['idParcours' => 1, 'parcours' => 'Tronc commun']];
        // S4 = 2 (parcours 2, 3, 4)
        $s4Parcours = $this->parcourModel->whereIn('idParcours', [2, 3, 4])->findAll();
        $parcoursBySemestre[2] = $s4Parcours;
        
        $data = [
            'etudiant' => $this->etudiantModel->findAll(),
            'semestre' => $this->semestreModel->findAll(),
            'matiere' => $this->matiereModel->findAll(),
            'parcour' => $this->parcourModel->findAll(),
            'matieresByParcours' => json_encode($matieresByParcours),
            'parcoursBySemestre' => json_encode($parcoursBySemestre),
            'note' => $this->noteModel->findAll()
        ];
        return view('noteform', $data);
    }

    public function getNotesByEtudiant($etu){
        $noteS3 = $this->getNotesS3($etu);
        $noteS4Dev = $this->getNotesS4ByParcours($etu, 1);
        $noteS4BddRes = $this->getNotesS4ByParcours($etu, 2);
        $noteS4Web = $this->getNotesS4ByParcours($etu, 3);

        $noteL2Dev = array_merge($noteS3, $noteS4Dev);
        $noteL2BddRes = array_merge($noteS3, $noteS4BddRes);
        $noteL2Web = array_merge($noteS3, $noteS4Web);

        $data = [
            'etudiant' => $this->etudiantModel->find($etu),
            'noteS3' => $noteS3,
            'noteS4Dev' => $noteS4Dev,
            'noteS4BddRes' => $noteS4BddRes,
            'noteS4Web' => $noteS4Web,
            'noteL2Dev' => $noteL2Dev,
            'noteL2BddRes' => $noteL2BddRes,
            'noteL2Web' => $noteL2Web,
            'totalCreditsS3' => $this->sumCredits($noteS3),
            'totalCreditsS4Dev' => $this->sumCredits($noteS4Dev),
            'totalCreditsS4BddRes' => $this->sumCredits($noteS4BddRes),
            'totalCreditsS4Web' => $this->sumCredits($noteS4Web),
            'totalCreditsL2Dev' => $this->sumCredits($noteL2Dev),
            'totalCreditsL2BddRes' => $this->sumCredits($noteL2BddRes),
            'totalCreditsL2Web' => $this->sumCredits($noteL2Web),
            'moyenneS3' => $this->calculateAverage($noteS3, $this->sumCredits($noteS3)),
            'moyenneS4Dev' => $this->calculateAverage($noteS4Dev, $this->sumCredits($noteS4Dev)),
            'moyenneS4BddRes' => $this->calculateAverage($noteS4BddRes, $this->sumCredits($noteS4BddRes)),
            'moyenneS4Web' => $this->calculateAverage($noteS4Web, $this->sumCredits($noteS4Web)),
            'moyenneL2Dev' => $this->calculateAverage($noteL2Dev, $this->sumCredits($noteL2Dev)),
            'moyenneL2BddRes' => $this->calculateAverage($noteL2BddRes, $this->sumCredits($noteL2BddRes)),
            'moyenneL2Web' => $this->calculateAverage($noteL2Web, $this->sumCredits($noteL2Web)),
        ];

        return view('vueNote', $data);
    }

    private function getNotesS3(string $etu): array
    {
        $definitions = [
            ['idMatiere' => 'INF201', 'nomMatiere' => 'Programmation orientée objet', 'Credit' => 6],
            ['idMatiere' => 'INF202', 'nomMatiere' => 'Base de données objet', 'Credit' => 6],
            ['idMatiere' => 'INF203', 'nomMatiere' => 'Programmation systeme', 'Credit' => 4],
            ['idMatiere' => 'INF208', 'nomMatiere' => 'Réseaux informatiques', 'Credit' => 6],
            ['idMatiere' => 'MTH201', 'nomMatiere' => 'Méthodes numériques', 'Credit' => 4],
            ['idMatiere' => 'ORG201', 'nomMatiere' => 'Bases de Gestion', 'Credit' => 4],
        ];

        $notesByMatiere = $this->fetchNotesByMatiere($etu, array_column($definitions, 'idMatiere'), null);

        $rows = [];
        foreach ($definitions as $definition) {
            $note = $notesByMatiere[$definition['idMatiere']] ?? null;
            $rows[] = [
                'idMatiere' => $definition['idMatiere'],
                'nomMatiere' => $definition['idMatiere'] . ' : ' . $definition['nomMatiere'],
                'Credit' => $definition['Credit'],
                'valeur' => (float) ($note['valeur'] ?? 0),
                'resultat' => (string) ($note['resultat'] ?? '-'),
            ];
        }

        return $rows;
    }

    private function getNotesS4ByParcours(string $etu, int $idParcours): array
    {
        $db = $this->matiereParcourModel->db;
        $escapedEtu = $db->escape($etu);

        $rows = $this->matiereParcourModel
            ->select("MatiereParcours.idMatiere, Matieres.Nom as nomMatiere, MatiereParcours.Credit, MatiereParcours.estObligatoire, COALESCE(Notes.valeur, 0) as valeur, COALESCE(Notes.resultat, '-') as resultat", false)
            ->join('Matieres', 'Matieres.idMatiere = MatiereParcours.idMatiere')
            ->join('Notes', "Notes.idMatiere = MatiereParcours.idMatiere AND Notes.idEtudiant = {$escapedEtu} AND Notes.idParcours = MatiereParcours.idParcours", 'left')
            ->where('MatiereParcours.idParcours', $idParcours)
            ->orderBy('MatiereParcours.idMatiere', 'ASC')
            ->findAll();

        $notes = [];
        $optionalGroups = [];
        $optionalOrder = [];

        foreach ($rows as $row) {
            if ((int) ($row['estObligatoire'] ?? 0) === 3) {
                $groupKey = (string) $row['Credit'];
                if (!isset($optionalGroups[$groupKey])) {
                    $optionalGroups[$groupKey] = [];
                    $optionalOrder[] = $groupKey;
                }

                $optionalGroups[$groupKey][] = $row;
                continue;
            }

            $notes[] = $this->normalizeNoteRow($row);
        }

        foreach ($optionalOrder as $groupKey) {
            $groupRows = $optionalGroups[$groupKey];
            $bestRow = $this->pickBestNote($groupRows);
            $label = '1 UE parmi : ' . implode(' / ', array_map(static function (array $item): string {
                return $item['idMatiere'] . ' : ' . $item['nomMatiere'];
            }, $groupRows));

            $notes[] = [
                'idMatiere' => $bestRow['idMatiere'] ?? $groupRows[0]['idMatiere'],
                'nomMatiere' => $label,
                'Credit' => (int) ($groupRows[0]['Credit'] ?? 0),
                'valeur' => (float) ($bestRow['valeur'] ?? 0),
                'resultat' => (string) ($bestRow['resultat'] ?? '-'),
            ];
        }

        return $notes;
    }

    private function sumCredits(array $notes): int
    {
        $total = 0;
        foreach ($notes as $note) {
            $total += (int) ($note['Credit'] ?? 0);
        }

        return $total;
    }

    private function calculateAverage(array $notes, int $totalCredits = 30): float
    {
        if ($totalCredits <= 0) {
            return 0.0;
        }

        $weightedSum = 0.0;
        foreach ($notes as $note) {
            $weightedSum += ((float) ($note['valeur'] ?? 0)) * ((int) ($note['Credit'] ?? 0));
        }

        return round($weightedSum / $totalCredits, 2);
    }

    private function fetchNotesByMatiere(string $etu, array $matiereIds, ?int $idParcours): array
    {
        $builder = $this->noteModel
            ->select('idMatiere, valeur, resultat')
            ->where('idEtudiant', $etu)
            ->whereIn('idMatiere', $matiereIds);

        if ($idParcours === null) {
            $builder->where('idParcours', null);
        } else {
            $builder->where('idParcours', $idParcours);
        }

        $rows = $builder->findAll();
        $indexed = [];

        foreach ($rows as $row) {
            $indexed[$row['idMatiere']] = $row;
        }

        return $indexed;
    }

    private function normalizeNoteRow(array $row): array
    {
        return [
            'idMatiere' => $row['idMatiere'],
            'nomMatiere' => $row['idMatiere'] . ' : ' . $row['nomMatiere'],
            'Credit' => (int) ($row['Credit'] ?? 0),
            'valeur' => (float) ($row['valeur'] ?? 0),
            'resultat' => (string) ($row['resultat'] ?? '-'),
        ];
    }

    private function pickBestNote(array $rows): array
    {
        $bestRow = $rows[0] ?? [];

        foreach ($rows as $row) {
            if ((float) ($row['valeur'] ?? 0) > (float) ($bestRow['valeur'] ?? 0)) {
                $bestRow = $row;
            }
        }

        return $bestRow;
    }

    public function getNotesByEtudiantAndSemestre($etu, $idSemestre)
    {
        return view('editNote', $this->buildEditableSemesterData((string) $etu, (int) $idSemestre));
    }

    public function updateSemester($etu, $idSemestre)
    {
        $idMatiere = (string) $this->request->getPost('idMatiere');
        $idParcours = $this->request->getPost('idParcours');
        $valeur = (float) $this->request->getPost('valeur');

        $saved = $this->saveNoteValue((string) $etu, $idMatiere, $idParcours !== '' ? (int) $idParcours : null, $valeur);

        if (!$saved) {
            return redirect()->back()->with('error', 'Erreur lors de la modification de la note');
        }

        return redirect()->to(site_url('modifiernote/' . $etu . '/' . $idSemestre))->with('success', 'Note modifiée avec succès');
    }

    public function removeSemester($etu, $idSemestre)
    {
        $idMatiere = (string) $this->request->getPost('idMatiere');
        $idParcours = $this->request->getPost('idParcours');

        $saved = $this->saveNoteValue((string) $etu, $idMatiere, $idParcours !== '' ? (int) $idParcours : null, 0.0, '0');

        if (!$saved) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de la note');
        }

        return redirect()->to(site_url('modifiernote/' . $etu . '/' . $idSemestre))->with('success', 'Note mise à zéro avec succès');
    }

    public function getNotesByEtudiantAndMatiere($etu, $idMatiere)
    {
        $notes = $this->noteModel
            ->select('idMatiere, idParcours, valeur, resultat')
            ->where('idEtudiant', $etu)
            ->where('idMatiere', $idMatiere)
            ->findAll();

        $data = [
            'etudiant' => $this->etudiantModel->find($etu),
            'matiere' => $this->matiereModel->find($idMatiere),
            'note' => $notes,
        ];

        return view('vueNote', $data);
    }

    public function getTotalCreditsByEtudiantAndSemestre($etu, $idSemestre)
    {
        $notes = (int) $idSemestre === 1 ? $this->getNotesS3($etu) : $this->getNotesS4ByParcours($etu, 1);

        return $this->sumCredits($notes);
    }

    private function buildEditableSemesterData(string $etu, int $idSemestre): array
    {
        $etudiant = $this->etudiantModel->find($etu);

        $sections = [];
        if ($idSemestre === 1) {
            $sections[] = [
                'title' => 'S3',
                'notes' => $this->getEditableNotesS3($etu),
            ];
        } else {
            $sections[] = [
                'title' => 'S4 - Développement',
                'notes' => $this->getEditableNotesS4ByParcours($etu, 1),
            ];
            $sections[] = [
                'title' => 'S4 - Bases de Données et Réseaux',
                'notes' => $this->getEditableNotesS4ByParcours($etu, 2),
            ];
            $sections[] = [
                'title' => 'S4 - Web et Design',
                'notes' => $this->getEditableNotesS4ByParcours($etu, 3),
            ];
        }

        return [
            'etudiant' => $etudiant,
            'idSemestre' => $idSemestre,
            'sections' => $sections,
        ];
    }

    private function getEditableNotesS3(string $etu): array
    {
        $definitions = [
            ['idMatiere' => 'INF201', 'nomMatiere' => 'Programmation orientée objet', 'Credit' => 6],
            ['idMatiere' => 'INF202', 'nomMatiere' => 'Base de données objet', 'Credit' => 6],
            ['idMatiere' => 'INF203', 'nomMatiere' => 'Programmation systeme', 'Credit' => 4],
            ['idMatiere' => 'INF208', 'nomMatiere' => 'Réseaux informatiques', 'Credit' => 6],
            ['idMatiere' => 'MTH201', 'nomMatiere' => 'Méthodes numériques', 'Credit' => 4],
            ['idMatiere' => 'ORG201', 'nomMatiere' => 'Bases de Gestion', 'Credit' => 4],
        ];

        $notesByMatiere = $this->fetchNotesByMatiere($etu, array_column($definitions, 'idMatiere'), null);

        $rows = [];
        foreach ($definitions as $definition) {
            $note = $notesByMatiere[$definition['idMatiere']] ?? null;
            $rows[] = [
                'idMatiere' => $definition['idMatiere'],
                'idParcours' => null,
                'nomMatiere' => $definition['nomMatiere'],
                'Credit' => $definition['Credit'],
                'valeur' => (float) ($note['valeur'] ?? 0),
                'resultat' => (string) ($note['resultat'] ?? '-'),
            ];
        }

        return $rows;
    }

    private function getEditableNotesS4ByParcours(string $etu, int $idParcours): array
    {
        $db = $this->matiereParcourModel->db;
        $escapedEtu = $db->escape($etu);

        $rows = $this->matiereParcourModel
            ->select('MatiereParcours.idMatiere, MatiereParcours.idParcours, Matieres.Nom as nomMatiere, MatiereParcours.Credit, COALESCE(Notes.valeur, 0) as valeur, COALESCE(Notes.resultat, \'-\') as resultat', false)
            ->join('Matieres', 'Matieres.idMatiere = MatiereParcours.idMatiere')
            ->join('Notes', "Notes.idMatiere = MatiereParcours.idMatiere AND Notes.idEtudiant = {$escapedEtu} AND Notes.idParcours = MatiereParcours.idParcours", 'left')
            ->where('MatiereParcours.idParcours', $idParcours)
            ->orderBy('MatiereParcours.idMatiere', 'ASC')
            ->findAll();

        $notes = [];
        foreach ($rows as $row) {
            $notes[] = [
                'idMatiere' => $row['idMatiere'],
                'idParcours' => (int) ($row['idParcours'] ?? $idParcours),
                'nomMatiere' => (string) ($row['nomMatiere'] ?? ''),
                'Credit' => (int) ($row['Credit'] ?? 0),
                'valeur' => (float) ($row['valeur'] ?? 0),
                'resultat' => (string) ($row['resultat'] ?? '-'),
            ];
        }

        return $notes;
    }

    private function saveNoteValue(string $etu, string $idMatiere, ?int $idParcours, float $valeur, ?string $forcedResultat = null): bool
    {
        $builder = $this->noteModel
            ->where('idEtudiant', $etu)
            ->where('idMatiere', $idMatiere);

        if ($idParcours === null) {
            $builder->where('idParcours', null);
        } else {
            $builder->where('idParcours', $idParcours);
        }

        $existing = $builder->first();

        $data = [
            'idEtudiant' => $etu,
            'idMatiere' => $idMatiere,
            'idParcours' => $idParcours,
            'valeur' => $valeur,
            'resultat' => $forcedResultat ?? $this->guessResultat($valeur),
        ];

        if ($existing) {
            return (bool) $this->noteModel->update($existing['idNote'], $data);
        }

        return (bool) $this->noteModel->insert($data);
    }

    private function guessResultat(float $valeur): string
    {
        if ($valeur <= 0) {
            return '0';
        }

        return $valeur >= 10 ? 'ADM' : 'AJR';
    }

    public function store()
    {
        $idEtudiant = $this->request->getPost('idEtudiant');
        $idMatiere = $this->request->getPost('idMatiere');
        $idParcours = $this->request->getPost('idParcours');
        $valeur = $this->request->getPost('valeur');
        $resultat = $this->request->getPost('resultat');

        $data = [
            'idEtudiant' => $idEtudiant,
            'idMatiere' => $idMatiere,
            'idParcours' => $idParcours,
            'valeur' => $valeur,
            'resultat' => $resultat
        ];

        if ($this->noteModel->insert($data)) {
            return redirect()->to('/list')->with('success', 'Note enregistrée avec succès');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement');
        }
    }
}
