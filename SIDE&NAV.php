<!--Paths updated-->

<aside class="left-sidebar with-vertical">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="./index.php" class="text-nowrap logo-img">
        <img src="./assets/images/logos/dark-logo.png" width="180" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar simplebar-scrollable-y">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu"><b>Menu</b></span>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="./index.php" aria-expanded="false">
            <span>
              <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Accueil</span>
          </a>
        </li>

        <li class="btn btn-toggle nav-small-cap ">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu"><b>Liste Stagiaires</b></span>
        </li>

        <li class="sidebar-item">
        <li class="sidebar-item align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#year1-collapse" aria-expanded="false">
          <a class="btn sidebar-link justify-content-between" aria-expanded="false">
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-layout-text-sidebar-reverse" viewBox="0 0 16 16">
                <path d="M12.5 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1h5zm0 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1h5zm.5 3.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5zm-.5 2.5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1h5z" />
                <path d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2zM4 1v14H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h2zm1 0h9a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5V1z" />
              </svg>
            </span>
            <span class="hide-menu">1ere annee</span>
            <span class="dropdownToggle">
              <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                <g id="chevron-down 1">
                  <path id="Vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M5.12259 7.64685C5.44802 7.32141 5.97566 7.32141 6.3011 7.64685L10.7118 12.0576L15.1226 7.64685C15.448 7.32141 15.9757 7.32141 16.3011 7.64685C16.6265 7.97229 16.6265 8.49992 16.3011 8.82536L11.3011 13.8254C10.9757 14.1508 10.448 14.1508 10.1226 13.8254L5.12259 8.82536C4.79715 8.49992 4.79715 7.97229 5.12259 7.64685Z" />
                </g>
              </svg>
            </span>
          </a>
        </li>

        <div class="collapse" id="year1-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small filieres-adjst">

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu"><b>Filieres</b></span>
            </li>

            <li class="sidebar-item">
            <li class="sidebar-item align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dd-filieres-collapse" aria-expanded="false">
              <a class="btn sidebar-link justify-content-between" aria-expanded="false">
                <span class="hide-menu">Developement digital</span>
                <span class="dropdownToggle">
                  <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                    <g id="chevron-down 1">
                      <path id="Vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M5.12259 7.64685C5.44802 7.32141 5.97566 7.32141 6.3011 7.64685L10.7118 12.0576L15.1226 7.64685C15.448 7.32141 15.9757 7.32141 16.3011 7.64685C16.6265 7.97229 16.6265 8.49992 16.3011 8.82536L11.3011 13.8254C10.9757 14.1508 10.448 14.1508 10.1226 13.8254L5.12259 8.82536C4.79715 8.49992 4.79715 7.97229 5.12259 7.64685Z" />
                    </g>
                  </svg>
                </span>
              </a>
            </li>

            <div class="collapse" id="dd-filieres-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li>
                  <ul class="filiere-classes">
                    <?php foreach ($devGroups as $group) : ?>
                      <li><a href="./listeNotesGroup.php?groupe=<?php echo $group ?>"><?= $group ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </li>

              </ul>
            </div>
            </li>

            <li class="sidebar-item">
            <li class="sidebar-item align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#id-filieres-collapse" aria-expanded="false">
              <a class="btn sidebar-link justify-content-between" aria-expanded="false">
                <span class="hide-menu">Infrastructure digital</span>
                <span class="dropdownToggle">
                  <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                    <g id="chevron-down 1">
                      <path id="Vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M5.12259 7.64685C5.44802 7.32141 5.97566 7.32141 6.3011 7.64685L10.7118 12.0576L15.1226 7.64685C15.448 7.32141 15.9757 7.32141 16.3011 7.64685C16.6265 7.97229 16.6265 8.49992 16.3011 8.82536L11.3011 13.8254C10.9757 14.1508 10.448 14.1508 10.1226 13.8254L5.12259 8.82536C4.79715 8.49992 4.79715 7.97229 5.12259 7.64685Z" />
                    </g>
                  </svg>
                </span>
              </a>
            </li>

            <div class="collapse" id="id-filieres-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                <li>
                  <ul class="filiere-classes">
                    <?php foreach ($idGroups as $group) : ?>
                      <li><a href="./listeNotesGroup.php?groupe=<?php echo $group ?>"><?= $group ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </li>

              </ul>
            </div>
            </li>

          </ul>
        </div>
        </li>

        <li class="sidebar-item">
        <li class="sidebar-item align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#year2-collapse" aria-expanded="false">
          <a class="btn sidebar-link justify-content-between" aria-expanded="false">
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-layout-text-sidebar-reverse" viewBox="0 0 16 16">
                <path d="M12.5 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1h5zm0 3a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1h5zm.5 3.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5zm-.5 2.5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1h5z" />
                <path d="M16 2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2zM4 1v14H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h2zm1 0h9a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5V1z" />
              </svg>
            </span>
            <span class="hide-menu">2eme annee</span>
            <span class="dropdownToggle">
              <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                <g id="chevron-down 1">
                  <path id="Vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M5.12259 7.64685C5.44802 7.32141 5.97566 7.32141 6.3011 7.64685L10.7118 12.0576L15.1226 7.64685C15.448 7.32141 15.9757 7.32141 16.3011 7.64685C16.6265 7.97229 16.6265 8.49992 16.3011 8.82536L11.3011 13.8254C10.9757 14.1508 10.448 14.1508 10.1226 13.8254L5.12259 8.82536C4.79715 8.49992 4.79715 7.97229 5.12259 7.64685Z" />
                </g>
              </svg>
            </span>
          </a>
        </li>

        <div class="collapse" id="year2-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small filieres-adjst">

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Filieres</span>
            </li>

            <li class="sidebar-item">
            <li class="sidebar-item align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#wfs-filieres-collapse" aria-expanded="false">
              <a class="btn sidebar-link justify-content-between" aria-expanded="false">
                <span class="hide-menu">Web Full Stack</span>
                <span class="dropdownToggle">
                  <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                    <g id="chevron-down 1">
                      <path id="Vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M5.12259 7.64685C5.44802 7.32141 5.97566 7.32141 6.3011 7.64685L10.7118 12.0576L15.1226 7.64685C15.448 7.32141 15.9757 7.32141 16.3011 7.64685C16.6265 7.97229 16.6265 8.49992 16.3011 8.82536L11.3011 13.8254C10.9757 14.1508 10.448 14.1508 10.1226 13.8254L5.12259 8.82536C4.79715 8.49992 4.79715 7.97229 5.12259 7.64685Z" />
                    </g>
                  </svg>
                </span>
              </a>
            </li>

            <div class="collapse" id="wfs-filieres-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                <li>
                  <ul class="filiere-classes">
                    <?php foreach ($wfsGroups as $group) : ?>
                      <li><a href="./listeNotesGroup.php?groupe=<?php echo $group ?>"><?= $group ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </li>

              </ul>
            </div>
            </li>

            <li class="sidebar-item">
            <li class="sidebar-item align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#am-filieres-collapse" aria-expanded="false">
              <a class="btn sidebar-link justify-content-between" aria-expanded="false">
                <span class="hide-menu">Application Mobile</span>
                <span class="dropdownToggle">
                  <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                    <g id="chevron-down 1">
                      <path id="Vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M5.12259 7.64685C5.44802 7.32141 5.97566 7.32141 6.3011 7.64685L10.7118 12.0576L15.1226 7.64685C15.448 7.32141 15.9757 7.32141 16.3011 7.64685C16.6265 7.97229 16.6265 8.49992 16.3011 8.82536L11.3011 13.8254C10.9757 14.1508 10.448 14.1508 10.1226 13.8254L5.12259 8.82536C4.79715 8.49992 4.79715 7.97229 5.12259 7.64685Z" />
                    </g>
                  </svg>
                </span>
              </a>
            </li>

            <div class="collapse" id="am-filieres-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                <li>
                  <ul class="filiere-classes">
                    <?php foreach ($amGroups as $group) : ?>
                      <li><a href="./listeNotesGroup.php?groupe=<?php echo $group ?>"><?= $group ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </li>

              </ul>
            </div>
            </li>

            <li class="sidebar-item">
            <li class="sidebar-item align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#sr-filieres-collapse" aria-expanded="false">
              <a class="btn sidebar-link justify-content-between" aria-expanded="false">
                <span class="hide-menu">Reseaux et Systemes</span>
                <span class="dropdownToggle">
                  <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                    <g id="chevron-down 1">
                      <path id="Vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M5.12259 7.64685C5.44802 7.32141 5.97566 7.32141 6.3011 7.64685L10.7118 12.0576L15.1226 7.64685C15.448 7.32141 15.9757 7.32141 16.3011 7.64685C16.6265 7.97229 16.6265 8.49992 16.3011 8.82536L11.3011 13.8254C10.9757 14.1508 10.448 14.1508 10.1226 13.8254L5.12259 8.82536C4.79715 8.49992 4.79715 7.97229 5.12259 7.64685Z" />
                    </g>
                  </svg>
                </span>
              </a>
            </li>

            <div class="collapse" id="sr-filieres-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                <li>
                  <ul class="filiere-classes">
                    <?php foreach ($srGroups as $group) : ?>
                      <li><a href="./listeNotesGroup.php?groupe=<?php echo $group ?>"><?= $group ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </li>

              </ul>
            </div>
            </li>

            <li class="sidebar-item">
            <li class="sidebar-item align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#cc-filieres-collapse" aria-expanded="false">
              <a class="btn sidebar-link justify-content-between" aria-expanded="false">
                <span class="hide-menu">Cloud Computing</span>
                <span class="dropdownToggle">
                  <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                    <g id="chevron-down 1">
                      <path id="Vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M5.12259 7.64685C5.44802 7.32141 5.97566 7.32141 6.3011 7.64685L10.7118 12.0576L15.1226 7.64685C15.448 7.32141 15.9757 7.32141 16.3011 7.64685C16.6265 7.97229 16.6265 8.49992 16.3011 8.82536L11.3011 13.8254C10.9757 14.1508 10.448 14.1508 10.1226 13.8254L5.12259 8.82536C4.79715 8.49992 4.79715 7.97229 5.12259 7.64685Z" />
                    </g>
                  </svg>
                </span>
              </a>
            </li>

            <div class="collapse" id="cc-filieres-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                <li>
                  <ul class="filiere-classes">
                    <?php foreach ($ccGroups as $group) : ?>
                      <li><a href="./listeNotesGroup.php?groupe=<?php echo $group ?>"><?= $group ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </li>

              </ul>
            </div>
            </li>

            <li class="sidebar-item">
            <li class="sidebar-item align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#cs-filieres-collapse" aria-expanded="false">
              <a class="btn sidebar-link justify-content-between" aria-expanded="false">
                <span class="hide-menu">Cyber sécurité</span>
                <span class="dropdownToggle">
                  <svg width="21" height="21" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg">
                    <g id="chevron-down 1">
                      <path id="Vector (Stroke)" fill-rule="evenodd" clip-rule="evenodd" d="M5.12259 7.64685C5.44802 7.32141 5.97566 7.32141 6.3011 7.64685L10.7118 12.0576L15.1226 7.64685C15.448 7.32141 15.9757 7.32141 16.3011 7.64685C16.6265 7.97229 16.6265 8.49992 16.3011 8.82536L11.3011 13.8254C10.9757 14.1508 10.448 14.1508 10.1226 13.8254L5.12259 8.82536C4.79715 8.49992 4.79715 7.97229 5.12259 7.64685Z" />
                    </g>
                  </svg>
                </span>
              </a>
            </li>

            <div class="collapse" id="cs-filieres-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                <li>
                  <ul class="filiere-classes">
                    <?php foreach ($csGroups as $group) : ?>
                      <li><a href="./listeNotesGroup.php?groupe=<?php echo $group ?>"><?= $group ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                </li>

              </ul>
            </div>
            </li>
          </ul>
        </div>
        </li>
      </ul>

    </nav>
    <!-- End Sidebar navigation -->
    <div class="fixed-profile px-3 py-1 mx-4 mb-3 bg-secondary-subtle rounded mt-3">
      <div class="hstack gap-3">
        <a href="./Profile.php" class="hstack gap-3" >
          <div class="avatar-container" data-initials="<?php echo extractInitials($_SESSION) ?>" data-width="50px" data-color="<?php echo $_SESSION["avatar"]  ?>"></div>
          <div class="john-title">
            <h6 class="mb-0 fs-4 fw-semibold"><?php echo $_SESSION["Nom"] . ' ' . $_SESSION["prenom"]  ?></h6>
            <span class="fs-2"><?php echo $_SESSION["Role"]  ?></span>
          </div>
        </a>
        <a href="./Php/sign_out.php" class="border-0 bg-transparent text-primary ms-auto" data-bs-toggle="tooltip" data-bs-placement="top" title="Se Deconnecter">
            <i class="ti ti-power fs-6"></i>
        </a>
      </div>
    </div>
  </div>
  <!-- End Sidebar scroll-->
</aside>
<div class="body-wrapper">

  <header class="app-header sticky-md-top" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1); height: 56px;">
    <nav class="navbar navbar-expand-lg navbar-light" style="min-height: 56px;max-height: 57px;">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
      </ul>
      <!-- <div class="navbar-collapse d-flex align-items-center justify-content-between px-0" id="navbarNav"> -->
      <ul class="navbar-nav  mb-0">
        <!-- Form searchbar-->
        <form action="#" method="POST" id="searchForm">
          <div class="SearchContainer">
            <div class="input-groupC">
              <input class="form-control rounded-3" type="search" value="" name="searchTerm" id="searchInput" placeholder="Search">
            </div>
            <div class="search-results" id="searchResults">
              <div class="lds-ellipsis" id="loadingIndicator">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
              </div>
            </div>
          </div>
        </form>
      </ul>

      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item dropdown">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar-container" data-initials="<?php echo extractInitials($_SESSION) ?>" data-width="35px" data-color="<?php echo $_SESSION["avatar"] ?>"></div>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
            <div class="message-body">
              <div class="py-3 px-7 pb-0">
                <h5 class="mb-0 fs-5 fw-semibold">Profil de l'utilisateur</h5>
              </div>
              <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                <div class="avatar-container" data-initials="<?php echo extractInitials($_SESSION) ?>" data-width="60px" data-color="<?php echo $_SESSION["avatar"] ?>"></div>
                <div class="ms-3">
                  <h5 class="mb-1 fs-3"><?php echo $_SESSION["Nom"] . ' ' . $_SESSION["prenom"] ?></h5>
                  <span class="mb-1 d-block"><?php echo $_SESSION["Role"] ?></span>
                  <p class="mb-0 d-flex align-items-center gap-2">
                    <i class="ti ti-mail fs-4"></i><?php echo $_SESSION["email"] ?>
                  </p>
                </div>
              </div>
              <a href="./Profile.php" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-user fs-6"></i>
                <p class="mb-0 fs-3">Mon Profile</p>
              </a>
              <?php if ($_SESSION["Role"] === "admin") { ?>
                <a href="./A-activityMonitor.php" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-activity fs-6"></i>
                  <p class="mb-0 fs-3">Surveillance d'Activité</p>
                </a>
                <a href="./A-userManagement.php" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-users fs-6"></i>
                  <p class="mb-0 fs-3">Gestion des Utilisateurs</p>
                </a>
                <a href="./A-dataManagement.php" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-database fs-6"></i>
                  <p class="mb-0 fs-3">Gestion des Données</p>
                </a>
              <?php } else { ?>
                <a href="./S-activityMonitor.php" class="d-flex align-items-center gap-2 dropdown-item">
                  <i class="ti ti-activity fs-6"></i>
                  <p class="mb-0 fs-3">Mes Activités</p>
                </a>
              <?php } ?>
              <a href="./elementsSupprimes.php" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-archive fs-6"></i>
                <p class="mb-0 fs-3">Éléments Supprimés</p>
              </a>
              <a href="./Php/sign_out.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Déconnexion</a>
            </div>
          </div>
        </li>
      </ul>
      <!-- </div> -->
    </nav>
  </header>