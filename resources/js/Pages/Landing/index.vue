<script setup>
import { ref } from "vue";
import { Head } from "@inertiajs/vue3";
import "./style.scss";
import logo from "@/assets/images/logo.png";
import personOne from "@/assets/images/person1.png";
import personTwo from "@/assets/images/person2.png";
import mapIcon from "@/assets/icons/landing/map.png";
import checkoutIcon from "@/assets/icons/landing/check-out.png";
import statisticIcon from "@/assets/icons/landing/table.png";
import proposalIcon from "@/assets/icons/landing/proposal.png";
import reportIcon from "@/assets/icons/landing/report.png";
import trackingIcon from "@/assets/icons/landing/tracking.png";
import dpIcon from "@/assets/icons/landing/development-plan.png";
import guideIcon from "@/assets/icons/landing/workshop.png";
import helpingHandIcon from "@/assets/icons/landing/helping-hand.png";
import unionIcon from "@/assets/icons/landing/union.png";
import instituteIcon from "@/assets/icons/landing/institute.png";
import workIcon from "@/assets/icons/landing/work.png";

const showSplash = ref(true);

setTimeout(() => {
    showSplash.value = false;
}, 1000);

const menus = [
    {
        href: route("portal.consultation"),
        imgSrc: reportIcon,
        title: "Layanan Konsultasi",
    },
    {
        href: route("portal.train-and-internship.index"),
        imgSrc: dpIcon,
        title: "Pelatihan Dan Pemagangan",
    },
    {
        href: route("filament.seeker.resources.claim-jhts.create"),
        imgSrc: helpingHandIcon,
        title: "Klaim JHT",
    },
    {
        href: route("filament.company.resources.company-legalizations.create"),
        imgSrc: statisticIcon,
        title: "Pengesahan Peraturan Perusahaan",
    },
    {
        href: route("filament.company.resources.company-laid-offs.create"),
        imgSrc: checkoutIcon,
        title: "Laporan PHK",
    },
    {
        href: route("filament.company.resources.jobs.create"),
        imgSrc: proposalIcon,
        title: "Pelaporan Lowongan",
    },
    {
        href: route("filament.company.resources.placements.create"),
        imgSrc: mapIcon,
        title: "Pelaporan Penempatan",
    },
    {
        href: route("filament.company.resources.labor-demands.create"),
        imgSrc: trackingIcon,
        title: "Permintaan Tenaga Kerja",
    },
    {
        href: route("portal.info-employment"),
        imgSrc: guideIcon,
        title: "Info Data Ketenagakerjaan",
    },

    {
        href: route(
            "filament.company.resources.labor-union-registrations.create",
        ),
        imgSrc: unionIcon,
        title: "Pendaftaran Serikat Pekerja",
    },
    {
        href: route(
            "filament.company.resources.institutional-approvals.create",
        ),
        imgSrc: instituteIcon,
        title: "Pengesahan Lembaga LKS BIPARTIT",
    },
    {
        href: "https://account.kemnaker.go.id/register",
        imgSrc: workIcon,
        title: "Pendaftaran AK 1",
        isExternal: true,
    },
];
</script>

<template>
    <div key="landing">

        <Head title="Landing" />
        <div class="splash" v-if="showSplash">
            <div class="left-half" style="width: 50%"></div>
            <div class="right-half" style="width: 50%"></div>
            <img :src="logo" alt="Kalimantan Tengah" class="kalteng-logo" />
        </div>
        <Transition>
            <div class="bg" v-if="!showSplash">
                <div class="overlay">
                    <div class="landing-container">
                        <div class="heading">
                            <img :src="logo" alt="Kalimantan Tengah" />
                            <a :href="route('portal')" class="homeContentEnterBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 248 51" version="1.1">
                                    <path d="M 3 4 L 8 27 L 3 51 L 248 51 L 243 27 L 248 4 z" fill="#000"
                                        fill-opacity="0.2"></path>
                                    <path d="M 0 0 L 5 23 L 0 47 L 245 47 L 240 23 L 245 0 z" fill="rgb(24,75,129)">
                                    </path>
                                </svg>
                                <div class="homeContentEnterLabel">
                                    MASUK WEBSITE
                                </div>
                            </a>
                        </div>
                        <div class="new-menus">
                            <a :href="menu.href" v-for="(menu, index) in menus" :key="index">
                                <div class="circle">
                                    <img :src="menu.imgSrc" :alt="menu.title" :target="menu.isExternal ? '_blank' : null
                                        " />
                                </div>
                                <p>{{ menu.title }}</p>
                            </a>
                        </div>
                        <div class="photos">
                            <img :src="personOne" alt="Gubenur & Wakil Gubenur" class="gub-wagub" />
                            <img :src="personTwo" alt="Kepala Dinas" class="kadis" />
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>
