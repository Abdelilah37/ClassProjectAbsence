<?php
      $sql = "SELECT * FROM logs where Username = ?  ORDER BY `Timestamp` DESC";
      $stmt =  $pdo_conn->prepare($sql);
      $stmt->bindParam(1, $user);
      $stmt->execute();
      $activites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

      <!-- table -->
      <div class="table-responsive hide-scroll table-container rounded border border-light shadow-sm" style="max-height:400px;overflow-y: scroll;">
            <table class="table table-hover align-middle">
                  <thead class="bg-gray-2  text-left fixed-thead">
                        <tr>
                              <th class="min-width-150 py-3 px-4 font-weight-medium">
                                    Journal d'activités D'utilisateur
                              </th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php if (!empty($activites)) : ?>
                              <?php foreach ($activites as $activite) : ?>
                                    <tr>
                                          <td class="border-bottom fw-bold py-3 px-4">
                                                <?php
                                                // remove the @ from the username
                                                $usernameParts = explode('@', $activite['Username']);
                                                $name = isset($usernameParts[0]) ? $usernameParts[0] : $activite['Username'];

                                                $stagiaireCin = $activite['StagiaireCin'];
                                                $StagiaireName = "SELECT nom, prenom FROM stagiaire WHERE cin = ?";
                                                $stmt = $pdo_conn->prepare($StagiaireName);
                                                $stmt->execute([$stagiaireCin]);
                                                $stagiaireInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                                                if (!$stagiaireInfo) {
                                                      $DeletedStagiaireName = "SELECT nom, prenom FROM deletedstagiaire WHERE cin = ?";
                                                      $stmt = $pdo_conn->prepare($DeletedStagiaireName);
                                                      $stmt->execute([$stagiaireCin]);
                                                      $deletedStagiaireInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                                                      if ($deletedStagiaireInfo) {
                                                            $fullName = $deletedStagiaireInfo['nom'] . ' ' . $deletedStagiaireInfo['prenom'];
                                                            echo "<span class='text-dark'>- Vous avez <b>{$activite['Action']}</b> {$fullName} (CIN: {$stagiaireCin}) le " . date('Y-m-d', strtotime($activite['Timestamp'])) . " à " . date('H:i:s', strtotime($activite['Timestamp'])) . ".</span>";
                                                      }
                                                } else {
                                                      $fullName = $stagiaireInfo['nom'] . ' ' . $stagiaireInfo['prenom'];
                                                      echo "<span class='text-dark'>- Vous avez <b> {$activite['Action']}</b> {$fullName} (CIN: {$stagiaireCin}) le " . date('Y-m-d', strtotime($activite['Timestamp'])) . " à " . date('H:i:s', strtotime($activite['Timestamp'])) . ".</span>";
                                                }
                                                ?>
                                          </td>
                                    </tr>
                              <?php endforeach; ?>
                        <?php else : ?>
                              <tr>
                                    <td>No Activities Available.</td>
                              </tr>
                        <?php endif; ?>
                  </tbody>
            </table>
      </div>