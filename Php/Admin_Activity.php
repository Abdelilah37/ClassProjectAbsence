<?php
$sql = "SELECT * FROM logs ORDER BY `Timestamp` DESC";
$stmt =  $pdo_conn->prepare($sql);
$stmt->execute();
$activites = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="table-responsive border hide-scroll customize-table mb-0 align-middle " style="overflow:auto">
      <table class="table" style="width:100%" id="dataTable">
            <thead class=" bg-light-gray text-left">
                  <tr>
                        <th class="min-width-220  fs-4 fw-semibold mb-0 text-dark">
                              Utilisateur
                        </th>
                        <th class="min-width-150 fs-4 fw-semibold mb-0 text-dark">
                              Action
                        </th>
                        <th class="min-width-120 fs-4 fw-semibold mb-0 text-dark">
                              Date
                        </th>
                  </tr>
            </thead>
            <tbody>
                  <?php if (!empty($activites)) : ?>
                        <?php foreach ($activites as $activite) : ?>
                              <tr>
                                    <?php



                                    $stagiaireCin = $activite['StagiaireCin'];
                                    $StagiaireName = "SELECT nom, prenom,cin FROM stagiaire WHERE cin = ?";
                                    $stmt = $pdo_conn->prepare($StagiaireName);
                                    $stmt->execute([$stagiaireCin]);
                                    $stagiaireInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                                    $username = $activite['Username'];
                                    $userSql = "SELECT Nom, prenom,avatar, Role FROM user WHERE username = ?";
                                    $stmt = $pdo_conn->prepare($userSql);
                                    $stmt->execute([$username]);
                                    $user1 = $stmt->fetch(PDO::FETCH_ASSOC);


                                    if (!$stagiaireInfo) {
                                          $DeletedStagiaireName = "SELECT cin,nom, prenom FROM deletedstagiaire WHERE cin = ?";
                                          $stmt = $pdo_conn->prepare($DeletedStagiaireName);
                                          $stmt->execute([$stagiaireCin]);
                                          $deletedStagiaireInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                                          if ($deletedStagiaireInfo) {
                                                $fullName = $deletedStagiaireInfo['nom'] . ' ' . $deletedStagiaireInfo['prenom'];
                                                echo "<td>
                                                      <div class='d-flex align-items-center'>
                                                            <span class='avatar-container' data-width='39px' data-initials='" . extractInitials($user1) . "' data-color='" . $user1['avatar'] . "'></span>
                                                            <div class='ms-3'>
                                                                  <h6 class='fs-4 fw-semibold mb-0'>
                                                                  " . (($user1['Nom'] || $user1['prenom']) ? ($user1['Nom'] . ' ' . $user1['prenom']) : $username) . "
                                                                  </h6>
                                                                  <span class='fw-normal'>" . $user1['Role'] . "</span>
                                                            </div>
                                                      </div>
                                                      </td>";



                                                echo "<td class=''>";
                                                if($deletedStagiaireInfo['cin'] == $stagiaireCin ){
                                                      echo "
                                                      <a href='#'>
                                            <span class='text-dark'><b>{$activite['Action']}</b> {$fullName} </span>
                                                      </a>
                                                      " ;
                                                }else{
                                                      echo "
                                                      <a href='./profileStagiaire.php?cin=$stagiaireCin'>
                                            <span class='text-dark'><b>{$activite['Action']}</b> {$fullName} </span>
                                                      </a>
                                                      ";
                                                };
                                                echo "</td>";



                                                echo "<td class=''>
                                      <span class='text-dark'>" . date('Y-m-d', strtotime($activite['Timestamp'])) . " à " . date('H:i:s', strtotime($activite['Timestamp'])) . ".</span>";
                                                "</td>";
                                          }
                                    } else {
                                          $fullName = $stagiaireInfo['nom'] . ' ' . $stagiaireInfo['prenom'];
                                          echo "<td>
                                                      <div class='d-flex align-items-center'>
                                                            <span class='avatar-container' data-width='39px' data-initials='" . extractInitials($user1) . "' data-color='" . $user1['avatar'] . "'></span>
                                                            <div class='ms-3'>
                                                                  <h6 class='fs-4 fw-semibold mb-0'>
                                                                  " . (($user1['Nom'] || $user1['prenom']) ? ($user1['Nom'] . ' ' . $user1['prenom']) : $username) . "
                                                                  </h6>
                                                                  <span class='fw-normal'>" . $user1['Role'] . "</span>
                                                            </div>
                                                      </div>
                                                      </td>";

                                          echo "<td class=''>
                                                      <a href='./profileStagiaire.php?cin=$stagiaireCin'>
                                            <span class='text-dark'><b>{$activite['Action']}</b> {$fullName} </span>
                                                      </a>";
                                          "</td>";



                                          echo "<td class=''>
                                      <span class='text-dark'>" . date('Y-m-d', strtotime($activite['Timestamp'])) . " à " . date('H:i:s', strtotime($activite['Timestamp'])) . ".</span>";
                                          "</td>";
                                    }
                                    ?>

                              </tr>
                        <?php endforeach; ?>
                  <?php else : ?>
                        <!-- <tr>
                              <td colspan="4">No deleted avertissements available.</td>
                        </tr> -->
                  <?php endif; ?>
            </tbody>
      </table>
</div>