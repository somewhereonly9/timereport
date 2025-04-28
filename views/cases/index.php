<!-- views/cases/index.php -->
<?php if (empty($cases)): ?>
    <p>No hay casos registrados.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Fecha</th>
                <th>Actor</th>
                <th>Abogado</th>
                <th>Etapa</th>
                <th>Demandado</th>
                <th>Cliente</th>
                <th>Autoridad</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($cases as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['folio']) ?></td>
                <td><?= htmlspecialchars($c['fecha']) ?></td>
                <td><?= htmlspecialchars($c['actor_name']) ?></td>
                <td><?= htmlspecialchars($c['lawyer_username']) ?></td>
                <td><?= htmlspecialchars($c['stage_name']) ?></td>
                <td><?= htmlspecialchars($c['defendant_name']) ?></td>
                <td><?= htmlspecialchars($c['company_name']) ?></td>
                <td><?= htmlspecialchars($c['authority_name']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>