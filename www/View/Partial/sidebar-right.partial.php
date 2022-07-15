<section id="sidebar-right">
    <nav class="sidebar-right">

        <div id="profile-container">
            <?php if(\App\Model\User::getUserConnected()->getAvatar() !== 0): ?>
                <figure>
                    <img src="<?php echo \App\Model\User::getUserConnected()->avatar(); ?>">
                </figure>
            <?php else: ?>
                <figure>
                    <img src="../../framework/assets/images/avatar.png">
                </figure>
            <?php endif; ?>

            <div>
                <h3><?php echo \App\Model\User::getUserConnected()->getFirstname(). " ".\App\Model\User::getUserConnected()->getLastname() ?></h3>

                <a href="/edit/profile">
                    Edit my profile
                    <svg class="ml-1" width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 10.292V13H2.70796L10.6946 5.01333L7.98667 2.30537L0 10.292ZM12.7888 2.91918C13.0704 2.63755 13.0704 2.18261 12.7888 1.90099L11.099 0.211221C10.8174 -0.0704069 10.3624 -0.0704069 10.0808 0.211221L8.75934 1.5327L11.4673 4.24066L12.7888 2.91918Z"
                              fill="#8B8CFB"/>
                    </svg>
                </a>
            </div>

        </div>


        <div id="part2">
            <h2>Infos</h2>
            <section>
                <div>
                    <h3>
                        Role:  <?php echo \App\Model\User::getUserConnected()->getRole() ?>
                    </h3>
                </div>
                <div>
                    <section class="rappel-icon">
                        <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.99979 0C5.40849 0 3.88236 0.632141 2.75715 1.75736C1.63193 2.88258 0.999787 4.4087 0.999787 6V9.586L0.292787 10.293C0.152977 10.4329 0.057771 10.611 0.0192035 10.805C-0.0193641 10.9989 0.000438951 11.2 0.076109 11.3827C0.151779 11.5654 0.279918 11.7215 0.444328 11.8314C0.608738 11.9413 0.802037 12 0.999787 12H12.9998C13.1975 12 13.3908 11.9413 13.5552 11.8314C13.7197 11.7215 13.8478 11.5654 13.9235 11.3827C13.9991 11.2 14.0189 10.9989 13.9804 10.805C13.9418 10.611 13.8466 10.4329 13.7068 10.293L12.9998 9.586V6C12.9998 4.4087 12.3676 2.88258 11.2424 1.75736C10.1172 0.632141 8.59109 0 6.99979 0ZM6.99979 16C6.20414 16 5.44108 15.6839 4.87847 15.1213C4.31586 14.5587 3.99979 13.7956 3.99979 13H9.99979C9.99979 13.7956 9.68372 14.5587 9.12111 15.1213C8.5585 15.6839 7.79544 16 6.99979 16Z"
                                  fill="#FFAD47"/>
                        </svg>
                    </section>
                    <section class="rappel-details">
                        <h3>lorem ipsum dolor sit amet</h3>
                        <h4>04 Jan, 09:20AM<small> Due Soon
                            </small></h4>
                    </section>

                </div>
                <div>
                    <section class="rappel-icon">
                        <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.99979 0C5.40849 0 3.88236 0.632141 2.75715 1.75736C1.63193 2.88258 0.999787 4.4087 0.999787 6V9.586L0.292787 10.293C0.152977 10.4329 0.057771 10.611 0.0192035 10.805C-0.0193641 10.9989 0.000438951 11.2 0.076109 11.3827C0.151779 11.5654 0.279918 11.7215 0.444328 11.8314C0.608738 11.9413 0.802037 12 0.999787 12H12.9998C13.1975 12 13.3908 11.9413 13.5552 11.8314C13.7197 11.7215 13.8478 11.5654 13.9235 11.3827C13.9991 11.2 14.0189 10.9989 13.9804 10.805C13.9418 10.611 13.8466 10.4329 13.7068 10.293L12.9998 9.586V6C12.9998 4.4087 12.3676 2.88258 11.2424 1.75736C10.1172 0.632141 8.59109 0 6.99979 0ZM6.99979 16C6.20414 16 5.44108 15.6839 4.87847 15.1213C4.31586 14.5587 3.99979 13.7956 3.99979 13H9.99979C9.99979 13.7956 9.68372 14.5587 9.12111 15.1213C8.5585 15.6839 7.79544 16 6.99979 16Z"
                                  fill="#FFAD47"/>
                        </svg>
                    </section>
                    <section class="rappel-details">
                        <h3>lorem ipsum dolor sit amet</h3>
                        <h4>04 Jan, 09:20AM<small> Due Soon
                            </small></h4>
                    </section>

                </div>
            </section>

        </div>
        <div id="part3">

            <h2>Recent Activity</h2>
            <section>
                <div>
                    <section class="rappel-icon">
                        <i class="bx bx-file"></i>
                    </section>
                    <section class="rappel-details">
                        <h3>lorem ipsum dolor sit amet</h3>
                        <h4>04 Jan, 09:20AM</h4>
                    </section>

                </div>
                <div>
                    <section class="rappel-icon">

                        <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.99979 0C5.40849 0 3.88236 0.632141 2.75715 1.75736C1.63193 2.88258 0.999787 4.4087 0.999787 6V9.586L0.292787 10.293C0.152977 10.4329 0.057771 10.611 0.0192035 10.805C-0.0193641 10.9989 0.000438951 11.2 0.076109 11.3827C0.151779 11.5654 0.279918 11.7215 0.444328 11.8314C0.608738 11.9413 0.802037 12 0.999787 12H12.9998C13.1975 12 13.3908 11.9413 13.5552 11.8314C13.7197 11.7215 13.8478 11.5654 13.9235 11.3827C13.9991 11.2 14.0189 10.9989 13.9804 10.805C13.9418 10.611 13.8466 10.4329 13.7068 10.293L12.9998 9.586V6C12.9998 4.4087 12.3676 2.88258 11.2424 1.75736C10.1172 0.632141 8.59109 0 6.99979 0ZM6.99979 16C6.20414 16 5.44108 15.6839 4.87847 15.1213C4.31586 14.5587 3.99979 13.7956 3.99979 13H9.99979C9.99979 13.7956 9.68372 14.5587 9.12111 15.1213C8.5585 15.6839 7.79544 16 6.99979 16Z"
                                  fill="#FFAD47"/>
                        </svg>

                    </section>
                    <section class="rappel-details">
                        <h3>Commentaire</h3>
                        <h4>04 Jan, 09:20AM</h4>
                    </section>

                </div>

                <div>
                    <section class="rappel-icon">
                        <span class="iconify prev" data-icon="ant-design:like-outlined"></span>
                    </section>
                    <section class="rappel-details">
                        <h3>Like</h3>
                        <h4>04 Jan, 09:20AM</h4>
                    </section>

                </div>
                <div>
                    <section class="rappel-icon">
                        <i class="bx bx-file"></i>
                    </section>
                    <section class="rappel-details">
                        <h3>lorem ipsum dolor sit amet</h3>
                        <h4>04 Jan, 09:20AM</h4>
                    </section>

                </div>
                <div>
                    <section class="rappel-icon">
                        <i class="bx bx-file"></i>
                    </section>
                    <section class="rappel-details">
                        <h3>lorem ipsum dolor sit amet</h3>
                        <h4>04 Jan, 09:20AM</h4>
                    </section>

                </div>
            </section>

        </div>
        <div id="part4">
            <h2>Completion Progress</h2>

            <section>

                <div>

                    <section class="info-courses">
                        <h3>Lorem ipsum </h3>
                        <h4>Chapter 3</h4>

                    </section>
                    <div class="skill">
                        <div class="outer">
                            <div class="inner">
                                <div class="number">65%</div>
                            </div>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="40px" height="40px">
                            <defs>
                                <linearGradient id="GradientColor">
                                    <stop offset="0%" style="stop-color:rgb(47,118,192);stop-opacity:1.00"/>
                                    <stop offset="99%" style="stop-color:rgb(59,205,179);stop-opacity:1.00"/>
                                </linearGradient>
                            </defs>
                            <circle cx="20" cy="20" r="18" stroke-linecap="round"/>
                        </svg>
                    </div>

                </div>


                <div>

                    <section class="info-courses">
                        <h3>Lorem ipsum </h3>
                        <h4>Chapter 3</h4>

                    </section>
                    <div class="skill">
                        <div class="outer">
                            <div class="inner">
                                <div class="number">65%</div>
                            </div>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="40px" height="40px">
                            <defs>
                                <linearGradient id="GradientColor">
                                    <stop offset="0%" style="stop-color:rgb(47,118,192);stop-opacity:1.00"/>
                                    <stop offset="99%" style="stop-color:rgb(59,205,179);stop-opacity:1.00"/>
                                </linearGradient>
                            </defs>
                            <circle cx="20" cy="20" r="18" stroke-linecap="round"/>
                        </svg>
                    </div>

                </div>


                <div>

                    <section class="info-courses">
                        <h3>Lorem ipsum </h3>
                        <h4>Chapter 3</h4>

                    </section>
                    <div class="skill">
                        <div class="outer">
                            <div class="inner">
                                <div class="number">65%</div>
                            </div>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="40px" height="40px">
                            <defs>
                                <linearGradient id="GradientColor">
                                    <stop offset="0%" style="stop-color:rgb(47,118,192);stop-opacity:1.00"/>
                                    <stop offset="99%" style="stop-color:rgb(59,205,179);stop-opacity:1.00"/>
                                </linearGradient>
                            </defs>
                            <circle cx="20" cy="20" r="18" stroke-linecap="round"/>
                        </svg>
                    </div>

                </div>

            </section>
        </div>

    </nav>

</section>
