import { Head } from "@inertiajs/react"
import './style.scss'
import kaltengLogo from '@/assets/images/kalteng-logo.png'
import gubWagub from '@/assets/images/gubWagub.png'
import kadis from '@/assets/images/kadis.png'
import mapIcon from '@/assets/icons/landing/map.png'
import graphicIcon from '@/assets/icons/landing/pie-chart.png'
import statisticIcon from '@/assets/icons/landing/table.png'
import proposalIcon from '@/assets/icons/landing/proposal.png'
import reportIcon from '@/assets/icons/landing/report.png'
import trackingIcon from '@/assets/icons/landing/tracking.png'
import dpIcon from '@/assets/icons/landing/development-plan.png'
import guideIcon from '@/assets/icons/landing/workshop.png'
import { Fragment, useEffect, useState } from "react"
import { AnimatePresence, motion } from "framer-motion"

export default function Landing() {
    const menus = [
        {
            href: route('portal'),
            imgSrc: mapIcon,
            title: "Layanan Konsultasi"
        },
        {
            href: route('portal'),
            imgSrc: graphicIcon,
            title: "Laporan PHK"
        },
        {
            href: route('portal'),
            imgSrc: statisticIcon,
            title: "Pengesahan Peraturan Perusahaan"
        },
        {
            href: route('portal'),
            imgSrc: proposalIcon,
            title: "Pelaporan Lowongan"
        },
        {
            href: route('portal'),
            imgSrc: reportIcon,
            title: "Pelaporan Penempatan"
        },
        {
            href: route('portal'),
            imgSrc: trackingIcon,
            title: "Permintaan Tenaga Kerja"
        },
        {
            href: route('portal'),
            imgSrc: dpIcon,
            title: "Pelatihan Dan Pemagangan"
        },
        {
            href: route('portal'),
            imgSrc: guideIcon,
            title: "Info Data Ketenagakerjaan"
        },
    ]

    const [showSplash, setShowSplash] = useState(true);
    useEffect(() => {
        const timer = setTimeout(() => {
            setShowSplash(false);
        }, 2000);

        return () => clearTimeout(timer);
    })
    return (
        <>
            <Head title="Portal" />
            <AnimatePresence initial={false}>
                {showSplash && (
                    <div className="splash">
                        <motion.div
                            className="left-half"
                            style={{ width: '50%' }}
                            animate={{ width: '50%' }}
                            exit={{ translateX: '-100%' }}
                            key="splash1"
                        />
                        <motion.div
                            className="right-half"
                            style={{ width: '50%' }}
                            animate={{ width: '50%' }}
                            exit={{ translateX: '100%' }}
                            key="splash2"
                        />
                        <motion.img
                            src={kaltengLogo}
                            alt="Kalimantan Tengah"
                            exit={{ translateY: '500%' }}
                            className="kalteng-logo"
                        />
                    </div>
                )}
                {!showSplash && (
                    <motion.div
                        className="bg"
                        initial={{ opacity: "0.5" }}
                        animate={{ opacity: 1 }}
                        key="bg"
                    >
                        <img src={gubWagub} alt="Gubenur & Wakil Gubenur" className="gub-wagub" />
                        <img src={kadis} alt="Kepala Dinas" className="kadis" />
                        <div className="overlay">
                            <div className="landing-container">
                                <div className="heading">
                                    <img src={kaltengLogo} alt="Kalimantan Tengah" />
                                    <h1>digi<span>park.</span></h1>
                                    <h5>Digital Palangka Raya Kreatif Ketenagakerjaan</h5>

                                    <a className="homeContentEnterBtn" href={route('portal')} style={{ top: "0px", visibility: "visible" }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 248 51" version="1.1">
                                            <path d="M 3 4 L 8 27 L 3 51 L 248 51 L 243 27 L 248 4 z" fill="#000" fill-opacity="0.2"></path>
                                            <path d="M 0 0 L 5 23 L 0 47 L 245 47 L 240 23 L 245 0 z" fill="rgb(176, 51, 34)"></path>
                                        </svg><div className="homeContentEnterLabel">MASUK WEBSITE</div>
                                    </a>
                                </div>
                                <div className="new-menus">
                                    {menus.map((menu, i) => (
                                        <a href={menu.href} key={i}>
                                            <div className="circle">
                                                <img src={menu.imgSrc} alt={menu.title} />
                                            </div>
                                            <p>{menu.title}</p>
                                        </a>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>
        </>
    )
}
